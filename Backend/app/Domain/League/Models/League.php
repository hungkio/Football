<?php

namespace App\Domain\League\Models;

use App\Domain\Admin\Models\Admin;
use App\Domain\Menu\Models\MenuItem;
use App\Support\Traits\MenuItemTrait;
use App\Support\Traits\Taxonable;
use Cviebrock\EloquentSluggable\Sluggable;
use App\Domain\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class League extends Model implements HasMedia
{
    use Sluggable;
    use Taxonable;
    use InteractsWithMedia;
    use MenuItemTrait;

    protected $guarded = [];

    protected $table = 'leagues';

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

    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection('league')
            ->singleFile();
    }
}
