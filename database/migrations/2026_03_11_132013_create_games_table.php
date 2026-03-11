<?php

declare(strict_types=1);

use App\Enums\ClubEvents\GameStatusEnum;
use App\Enums\ClubEvents\GameTypeEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * The word 'Match is reserved in PHP, so we chose to use 'Game' to define a match in English.
 */
return new class extends Migration
{
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('games');
    }

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('games', function (Blueprint $table) {
            $table->id();
            $table->enum('game_type', GameTypeEnum::cases());
            $table->morphs('source'); // Will create a source_id (bigInt) and source_type (string) linked to the good table
            $table->boolean('is_double')->default(false);
            $table->tinyInteger('winner_side'); // 1 for Home/US, 2 for Away/Them
            $table->enum('game_status', GameStatusEnum::cases())->default('pending');
            $table->timestamps();
        });
    }
};
