<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Taxonable extends Model
{
    use HasFactory;

    protected $fillable = [
        'taxon_id', 'taxonable_type', 'taxonable_id'
    ];

    const BE_POST_MODEL = 'App\Domain\Post\Models\Post';
}
