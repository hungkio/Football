<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    use HasFactory;

    protected $fillable = [
        'api_id', 
        'name', 
        'first_name', 
        'last_name', 
        'age', 
        'date_of_birth', 
        'place_of_birth',
        'country',
        'nationality',
        'height',
        'weight',
        'injured',
        'photo'
    ];
}
