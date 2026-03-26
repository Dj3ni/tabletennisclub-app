<?php

declare(strict_types=1);

namespace App\Services\ClubEvents;

use App\Models\ClubEvents\Game;
use App\Models\ClubEvents\GameParticipant;

class GameService
{
    public function __construct(
        private readonly HandicapPointsService $handicapPointsService,
        private readonly SetService $setService
    ) {}

    public function startGame(Game $game, array $playersBySide): void {
        // 1. Créer les GameParticipants avec handicap calculé
        foreach ($playersBySide as $side => $playerIds) {
            foreach ($playerIds as $playerId) {
                $handicap = $this->handicapPointsService->calculate($playerId, $game);

                GameParticipant::create([
                    'game_id'         => $game->id,
                    'player_id'       => $playerId,
                    'side'            => $side,
                    'handicap_points' => $handicap,
                ]);
            }
        }
    }
}
