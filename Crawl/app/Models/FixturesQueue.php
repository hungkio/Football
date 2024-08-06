<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FixturesQueue extends Model
{
    use HasFactory;

    const CRAWLED = 1;
    const NOTCRAWLED = 0;

}
