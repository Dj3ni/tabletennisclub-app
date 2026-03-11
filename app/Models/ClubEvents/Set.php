<?php

namespace App\Models\ClubEvents;

use Illuminate\Database\Eloquent\Model;

class Set extends Model
{
    protected $casts = [
        'game_id' => 'integer',
        'set_number' => 'integer',
        'score_side_1' => 'integer',
        'score_side_2' => 'integer',
    ];

    protected $fillable = [
        'game_id',
        'set_number',
        'score_side_1',
        'score_side_2',
    ];

}
