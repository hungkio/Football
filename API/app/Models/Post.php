<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'on_pages',
        'user_id',
        'title',
        'description',
        'slug',
        'body',
        'view',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'related_posts',
        'title_vi',
        'description_vi',
        'body_vi',
        'meta_title_vi',
        'meta_description_vi',
        'meta_keywords_vi',
    ];

    protected $casts = [
        'related_posts' => 'array',
        'on_pages' => 'array'
    ];

    /**
     * @inheritDoc
     */
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }
}
