<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Taxon extends Model
{
    use HasFactory;

    protected $table = 'taxons';

    protected $fillable = [
        'parent_id',
        'taxonomy_id',
        'name',
        'slug',
        'description',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'order_column',
    ];

    const CATEGORY = 1;

    public function children()
    {
        return $this->hasMany(Taxon::class, 'parent_id');
    }

    public function allChildren()
    {
        return $this->children()->with('allChildren');
    }

    public function parent()
    {
        return $this->belongsTo(Taxon::class, 'parent_id');
    }
}
