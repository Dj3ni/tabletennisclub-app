<?php

declare(strict_types=1);

namespace Tests\Unit\Enums\ClubEvents;

use App\Enums\ClubEvents\GameStatusEnum;

describe('GameStatusEnum', function () {

    it('GetLabel function returns the correct label', function () {
        $this->assertEquals(__('Pending'), GameStatusEnum::PENDING->getLabel());
        $this->assertEquals(__('Ready'), GameStatusEnum::READY->getLabel());
        $this->assertEquals(__('In Progress'), GameStatusEnum::IN_PROGRESS->getLabel());
        $this->assertEquals(__('Paused'), GameStatusEnum::PAUSED->getLabel());
        $this->assertEquals(__('Finished'), GameStatusEnum::FINISHED->getLabel());
        $this->assertEquals(__('Cancelled'), GameStatusEnum::CANCELLED->getLabel());
    });

    it('Returns the good string', function () {
        $this->assertEquals(GameStatusEnum::PENDING, GameStatusEnum::from('Pending'));
        $this->assertEquals(GameStatusEnum::READY, GameStatusEnum::from('Ready'));
        $this->assertEquals(GameStatusEnum::IN_PROGRESS, GameStatusEnum::from('In_progress'));
        $this->assertEquals(GameStatusEnum::PAUSED, GameStatusEnum::from('Paused'));
        $this->assertEquals(GameStatusEnum::FINISHED, GameStatusEnum::from('Finished'));
        $this->assertEquals(GameStatusEnum::CANCELLED, GameStatusEnum::from('Cancelled'));
    });

    // Is this test useful?
    it('values() returns the array of values', function () {
        $this->assertEquals(
            array_map(fn ($case) => $case->value, GameStatusEnum::cases()),
            GameStatusEnum::values()
        );
    });

    it('Returns null when value not in enum', function () {
        $this->assertNull(GameStatusEnum::tryFrom('unknown'));
        $this->assertNull(GameStatusEnum::tryFrom('hello'));
    });

})->group('match', 'interclub', 'tournament');
