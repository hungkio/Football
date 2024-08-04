<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coach extends Model
{
    use HasFactory;

    protected $fillable = [
        'api_id',
        'name',
        'firstname',
        'lastname',
        'age',
        'date_of_birth',
        'place_of_birth',
        'country',
        'nationality',
        'height',
        'weight',
        'photo',
        'team_id',
        'career',
    ];

    protected $casts = [
        'career' => 'array'
    ];
}
