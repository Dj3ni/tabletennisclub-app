<?php

declare(strict_types=1);

namespace App\Enums\ClubEvents;

enum GameStatusEnum: string
{
    case CANCELLED = 'Cancelled'; // (Forfeit, rain, ...)
    case FINISHED = 'Finished';  // Last point marked
    case IN_PROGRESS = 'In_progress';
    case PAUSED = 'Paused';    // Brak / Emergency
    case PENDING = 'Pending';   // Planned but not started
    case READY = 'Ready';     // Waiting for players to start

    /**
     * Return the values of the enum into an array
     */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    /**
     * Return the localized string of a particular value
     */
    public function getLabel(): string
    {
        return match ($this) {
            self::PENDING => __('Pending'),
            self::READY => __('Ready'),
            self::IN_PROGRESS => __('In Progress'),
            self::PAUSED => __('Paused'),
            self::FINISHED => __('Finished'),
            self::CANCELLED => __('Cancelled'),
        };
    }
}
