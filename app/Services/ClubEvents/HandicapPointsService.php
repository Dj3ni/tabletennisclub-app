<?php

declare(strict_types=1);

namespace App\Services\ClubEvents;

use InvalidArgumentException;

class HandicapPointsService
{
    private const RANKING_POWER = [
        'A1' => 0, 'A2' => 0, 'A3' => 0, 'A4' => 0, 'A5' => 0,
        'A6' => 0, 'A7' => 0, 'A8' => 0, 'A9' => 0, 'A10' => 0,
        'A11' => 0, 'A12' => 0, 'A13' => 0, 'A14' => 0, 'A15' => 0,
        'B0' => 1,  'B2' => 2,  'B4' => 3,  'B6' => 4,
        'C0' => 5,  'C2' => 6,  'C4' => 7,  'C6' => 8,
        'D0' => 9,  'D2' => 10, 'D4' => 11, 'D6' => 12,
        'E0' => 13, 'E2' => 14, 'E4' => 15,
        'E6' => 16, 'NC' => 16, 'NA' => 16,
    ];

    public function calculate(array $teamA, array $teamB): int
    {
        $powerA = $this->getTeamPower($teamA);
        $powerB = $this->getTeamPower($teamB);

        // L'écart de puissance
        $diff = $powerB - $powerA;

        if ($diff <= 0) {
            return 0;
        }

        // Règle AFTT : 1 point de handicap par tranche de 2 niveaux d'écart
        return min(8, (int) ceil($diff / 2));
    }

    private function getTeamPower(array $players): float
    {
        if (empty($players)) {
            throw new InvalidArgumentException(__('A team must contain at least one player'));
        }
        $totalPower = 0;
        foreach ($players as $rank) {
            if (! isset(self::RANKING_POWER[$rank])) {
                throw new InvalidArgumentException(__("The ranking [{$rank}] is not valid"));
            }
            $totalPower += self::RANKING_POWER[$rank];
        }

        // Pour un simple, divise par 1. Pour un double, divise par 2.
        return $totalPower / count($players);
    }
}
