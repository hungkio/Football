<?php

namespace App\Domain\Country\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\HasMedia;
class Country extends Model implements HasMedia
{
    use InteractsWithMedia;

    public $guarded = [];

    protected $fillable = [
        'name',
        'code',
        'flag',
        'from_team',
        'name_vi',
        'slug',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'meta_title_vi',
        'meta_description_vi',
        'meta_keywords_vi'
    ];

    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection('country')
            ->singleFile();
    }
}
