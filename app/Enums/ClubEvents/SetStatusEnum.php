<?php

declare(strict_types=1);

namespace App\Enums\ClubEvents;

enum SetStatusEnum: string
{
    case CORRECTED = 'Corrected';    // corrected scores after match
    case FINISHED = 'Finished';
    case IN_PROGRESS = 'In_progress';
    case PENDING = 'Pending';

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
            self::IN_PROGRESS => __('In Progress'),
            self::FINISHED => __('Finished'),
            self::CORRECTED => __('Corrected'),
        };
    }

    public function isEditable(): bool
    {
        return match ($this) {
            self::IN_PROGRESS,
            self::FINISHED,
            self::CORRECTED => true,
            self::PENDING => false,
        };
    }
}
