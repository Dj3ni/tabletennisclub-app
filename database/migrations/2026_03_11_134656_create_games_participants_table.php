<?php

use App\Models\ClubAdmin\Users\User;
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
        Schema::create('games_participants', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Game::class)->constrained();
            $table->foreignIdFor(User::class)->constrained();
            $table->tinyInteger('side'); // 1 = Home, 2 = Away
            $table->integer('handicap_points')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('games_participants');
    }
};
