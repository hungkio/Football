<?php

namespace App\Domain\ToolRedirecter\Models;

use App\Support\Traits\MenuItemTrait;
use App\Support\Traits\Taxonable;
use Cviebrock\EloquentSluggable\Sluggable;
use App\Domain\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class ToolRedirecter extends Model implements HasMedia
{
    use Sluggable;
    use Taxonable;
    use InteractsWithMedia;
    use MenuItemTrait;

    protected $guarded = [];

    protected $table = 'tool_redirecters';

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
