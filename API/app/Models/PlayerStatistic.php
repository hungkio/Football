<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlayerStatistic extends Model
{
    use HasFactory;

    protected $casts = [
        'games' => 'array',
        'substitutes' => 'array',
        'shots' => 'array',
        'goals' => 'array',
        'passes' => 'array',
        'tackles' => 'array',
        'duels' => 'array',
        'dribbles' => 'array',
        'fouls' => 'array',
        'cards' => 'array',
        'penalty' => 'array',
    ];
}
