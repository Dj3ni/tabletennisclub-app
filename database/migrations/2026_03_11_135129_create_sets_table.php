<?php

use App\Models\ClubEvents\Game;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('sets', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Game::class)->constrained();
            $table->unsignedInteger('set_number');
            $table->unsignedInteger('score_side_1')->nullable();
            $table->unsignedInteger('score_side_2')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sets');
    }
};
