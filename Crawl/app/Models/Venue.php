<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venue extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'api_id', 'name', 'address', 'city', 'country', 'capacity', 'surface', 'image'
    ];
}
