<?php

namespace App\Enums\ClubEvents;

enum GameTypeEnum : string
{
    case TOURNAMENT = "Tournament";
    case INTERCLUB = "Interclub";

    /**
     * Return the values of the enum into an array
     * @return array
     */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    /**
     * Return the localized string of a particular value
     * @return string
     */
    public function getLabel(): string
    {
        return match ($this) {
            self::INTERCLUB => __('Interclub'),
            self::TOURNAMENT => __('Tournament'),
        };
    }

}

