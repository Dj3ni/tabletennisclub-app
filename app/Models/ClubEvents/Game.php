<?php

namespace App\Models\ClubEvents;

use App\Enums\ClubEvents\GameStatusEnum;
use App\Enums\ClubEvents\GameTypeEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Game extends Model
{
    protected $casts = [
        'game_type' => GameTypeEnum::class,
        'source_id' => 'integer',
        'is_double' => 'boolean',
        'winner_side' => 'tinyInteger',
        'game_status' => GameStatusEnum::class,
    ];

    protected $fillable = [
        'game_type',
        'source_id',
        'is_double',
        'winner_side',
        'game_status',
    ];

    public function source(): BelongsTo
    {
        return $this->morphTo();
    }

}
