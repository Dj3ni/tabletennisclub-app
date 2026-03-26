<?php

declare(strict_types=1);

namespace App\Models\ClubEvents;

use App\Enums\ClubEvents\GameStatusEnum;
use App\Enums\ClubEvents\GameTypeEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Game extends Model
{
    protected $casts = [
        'game_type' => GameTypeEnum::class,
        'source_id' => 'integer',
        'is_double' => 'boolean',
        'sets_to_play' => 'integer',
        'sets_to_win' => 'integer',
        'winner_side' => 'tinyInteger',
        'game_status' => GameStatusEnum::class,
    ];

    protected $fillable = [
        'game_type',
        'source_id',
        'is_double',
        'sets_to_play',
        'sets_to_win',
        'winner_side',
        'game_status',
    ];

    public function participants(): HasMany
    {
        return $this->hasMany(GameParticipant::class);
    }

    public function sets(): HasMany
    {
        return $this->hasMany(Set::class);
    }

    public function source(): BelongsTo
    {
        return $this->morphTo();
    }
}
