<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Standing extends Model
{
    use HasFactory;
    protected $fillable = [
        'league_id',
        'season',
        'team_id',
        'rank',
        'points',
        'goalsDiff',
        'group',
        'form',
        'status',
        'description',
        'all',
        'home',
        'away',
    ];
    protected $casts = [
        'all' => 'array',
        'home' => 'array',
        'away' => 'array',
    ];
}
