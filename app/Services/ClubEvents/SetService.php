<?php

declare(strict_types=1);

namespace App\Services\ClubEvents;

use App\Models\ClubEvents\Game;
use App\Models\ClubEvents\Set;

class SetService
{
    public function startSet(Game $game, int $setNumber): Set
    {
        return Set::create([
            'game_id' => $game->id,
            'set_number' => $setNumber,

        ]);
    }
}
