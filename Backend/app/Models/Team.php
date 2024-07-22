<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;
    
    protected $fillables = [
        'api_id', 
        'name', 
        'code', 
        'country', 
        'national', 
        'logo', 
        'league_id', 
        'season'
    ];
}
