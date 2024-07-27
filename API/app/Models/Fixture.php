<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fixture extends Model
{
    use HasFactory;

    protected $fillable = ['fixture', 'league', 'teams', 'goals', 'score'];
    protected $casts = [
        'fixture' => 'array',
        'league' => 'array',
        'teams' => 'array',
        'goals' => 'array',
        'score' => 'array',
        'periods' => 'array',
        'venue' => 'array',
        'status' => 'array',
    ];
}
