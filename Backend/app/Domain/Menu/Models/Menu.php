<?php

namespace App\Domain\Menu\Models;

use App\Support\Traits\IsSorted;
use App\Support\Traits\Taxonable;
use Cviebrock\EloquentSluggable\Sluggable;
use App\Domain\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Menu extends Model implements HasMedia
{
    use Sluggable;
    use Taxonable;
    use InteractsWithMedia;
    use IsSorted;

    protected $guarded = [];
    protected $table = 'menus';
    protected $fillable = ['name', 'status', 'internal_url', 'external_link'];

    const STATUS_HIDE = 0;
    const STATUS_SHOW = 1;
    const STATUS = [
        self::STATUS_HIDE => 'Ẩn',
        self::STATUS_SHOW => 'Hiển thị',
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

    public function menus()
    {
        return $this->hasMany(MenuItem::class, 'menu_id', 'id');
    }

    public function rootMenuItem()
    {
        return $this->hasOne(MenuItem::class, 'menu_id', 'id')->whereNull('parent_id');
    }
}
