<?php

namespace App\Models\ClubEvents;

use Illuminate\Database\Eloquent\Model;

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
}
