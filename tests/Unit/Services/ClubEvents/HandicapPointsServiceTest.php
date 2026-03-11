<?php

declare(strict_types=1);

namespace Tests\Unit\Services\ClubEvents;

use App\Services\ClubEvents\HandicapPointsService;
use InvalidArgumentException;

describe('HandicapPointsService', function () {
    beforeEach(fn () => $this->service = new HandicapPointsService);

    /**
     * Simple Matches
     */
    it('calculates correct handicap in simple matches', function ($rankA, $rankB, $expected) {
        expect($this->service->calculate([$rankA], [$rankB]))->toBe($expected);
    })->with([
        // [Player A, Player B, Expected Result]
        ['B0', 'B0', 0], // Same level
        ['B0', 'B2', 1], // 1 diff -> 1pt
        ['B0', 'B4', 1], // 2 diff -> 1pt (ceil(2/2))
        ['B0', 'B6', 2], // 3 diff -> 2pts (ceil(3/2))
        ['B0', 'C0', 2], // 4 diff -> 2pts
        ['B0', 'NC', 8], // Huge diff -> max 8
        ['C0', 'B0', 0], // Strongest gets 0
    ]);

    /**
     * Specificity E0 / NC / NA
     */
    it('Should be 0 as E6, NC and NA have the same power', function ($rankA, $rankB) {
        expect($this->service->calculate([$rankA], [$rankB]))->toBe(0);
    })->with([
        ['E6', 'NC'],
        ['NC', 'NA'],
        ['NA', 'E6'],
    ]);

    /**
     * Test des Doubles
     */
    it('calculate correct handicap for doubles (average)', function ($teamA, $teamB, $expected) {
        expect($this->service->calculate($teamA, $teamB))->toBe($expected);
    })->with([
        // (1+1)/2 vs (2+2)/2 = 1 vs 2. Diff 1 -> 1pt
        [['B0', 'B0'], ['B2', 'B2'], 1],

        // Average B2 vs 2 B2 -> Diff 0
        [['B0', 'B4'], ['B2', 'B2'], 0],

        // Very strong team vs very weak
        [['B0', 'B0'], ['NC', 'NC'], 8],

        // B0+C0 (Average 3) vs D0+E0 (Average 11)
        // Diff = 8 -> ceil(8/2) = 4pts
        [['B0', 'C0'], ['D0', 'E0'], 4],
    ]);

    /**
     * Security
     */

    it('raises an exception if invalid ranking', function () {
        $this->service->calculate(['B0'], ['Z9']);
    })->throws(InvalidArgumentException::class, 'The ranking [Z9] is not valid');

    it('raises an exception if a team is empty', function () {
        $this->service->calculate([], ['B0']);
    })->throws(InvalidArgumentException::class, 'A team must contain at least one player');

})->group('match', 'interclub', 'tournament');
