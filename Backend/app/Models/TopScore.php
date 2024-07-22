<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TopScore extends Model
{
    use HasFactory;

    protected $fillable = [
        'player_id', 'league_id', 'season'
    ];
}
