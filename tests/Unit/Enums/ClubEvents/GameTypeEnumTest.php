<?php

declare(strict_types=1);

namespace Tests\Unit\Enums\ClubEvents;

use App\Enums\ClubEvents\GameTypeEnum;

describe('GameTypeEnum', function () {

    it('GetLabel function returns the correct label', function () {
        $this->assertEquals(__('Tournament'), GameTypeEnum::TOURNAMENT->getLabel());
        $this->assertEquals(__('Interclub'), GameTypeEnum::INTERCLUB->getLabel());
    });

    it('Returns the good string', function () {
        $this->assertEquals(GameTypeEnum::TOURNAMENT, GameTypeEnum::from('Tournament'));
        $this->assertEquals(GameTypeEnum::INTERCLUB, GameTypeEnum::from('Interclub'));
    });

    // Is this test useful?
    it('values() returns the array of values', function () {
        $this->assertEquals(
            array_map(fn ($case) => $case->value, GameTypeEnum::cases()),
            GameTypeEnum::values()
        );
    });

    it('Returns null when value not in enum', function () {
        $this->assertNull(GameTypeEnum::tryFrom('unknown'));
        $this->assertNull(GameTypeEnum::tryFrom('hello'));
    });

})->group('match', 'interclub', 'tournament');
