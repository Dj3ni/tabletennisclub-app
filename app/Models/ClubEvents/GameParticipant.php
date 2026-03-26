<?php

namespace App\Models\ClubEvents;

use App\Models\ClubAdmin\Users\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GameParticipant extends Model
{
    protected $casts = [
        'game_id' => 'integer',
        'player_id' => 'integer',
        'side' => 'integer',
        'handicap_points' => 'integer',
    ];

    protected $fillable = [
        'game_id',
        'player_id',
        'side',
        'handicap_points',
    ];

    public function game(): BelongsTo
    {
        return $this->belongsTo(Game::class);
    }

    public function player(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
