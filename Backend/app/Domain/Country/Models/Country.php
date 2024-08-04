<?php

namespace App\Domain\Country\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\HasMedia;
class Country extends Model implements HasMedia
{
    use InteractsWithMedia;
    use Sluggable;

    public $guarded = [];

    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection('country')
            ->singleFile();
    }

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
