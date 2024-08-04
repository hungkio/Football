<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fixture extends Model
{
    use HasFactory;

    protected $fillable = [
        'api_id', 
        'referee', 
        'timezone', 
        'date', 
        'timestamp', 
        'periods', 
        'venue', 
        'status', 
        'league', 
        'teams', 
        'goals', 
        'score'
    ];
    protected $casts = [
        'periods' => 'array',
        'venue' => 'array',
        'status' => 'array',
        'league' => 'array',
        'teams' => 'array',
        'goals' => 'array',
        'score' => 'array',
    ];
}
