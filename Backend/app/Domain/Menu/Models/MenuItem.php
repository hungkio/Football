<?php

namespace App\Domain\Menu\Models;

use App\Domain\Page\Models\Page;
use App\Domain\Post\Models\Post;
use App\Domain\Taxonomy\Models\Taxon;
use App\Support\Traits\Taxonable;
use Cviebrock\EloquentSluggable\Sluggable;
use App\Domain\Model;
use Illuminate\Support\Facades\Cache;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Staudenmeir\LaravelAdjacencyList\Eloquent\HasRecursiveRelationships;

class MenuItem extends Model implements HasMedia
{
    use Sluggable;
    use Taxonable;
    use InteractsWithMedia;
    use HasRecursiveRelationships;

    protected $guarded = [];
    protected $table = 'menu_items';
    protected $fillable = ['menu_id', 'type', 'status', 'item_id', 'name', 'parent_id', 'item_content'];

    const TYPE_CATEGORY = 1;
    const TYPE_PAGE = 2;
    const TYPE_LINK = 3;
    const TYPE_POST = 4;
    const STATUS_HIDE = 0;
    const STATUS_SHOW = 1;

    const TYPE = [
        self::TYPE_CATEGORY => 'Danh mục bài viết',
        self::TYPE_PAGE => 'Trang',
        self::TYPE_LINK => 'Đường dẫn',
        self::TYPE_POST => 'Bài viết',
    ];
    const STATUS = [
        self::STATUS_HIDE => 'Ẩn',
        self::STATUS_SHOW => 'Hiển thị',
    ];

    protected static function boot()
    {
        parent::boot();

        static::saved(function($menuItem)
        {
            Cache::forget('menu-header');
            Cache::forget('menu-footer-1');
            Cache::forget('menu-footer-2');
        });
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

    public function childs(){
        return $this->hasMany(MenuItem::class, 'parent_id', 'id');
    }

    public function taxon() {
        return $this->belongsTo(Taxon::class, 'item_id', 'id');
    }

    public function post() {
        return $this->belongsTo(Post::class, 'item_id', 'id');
    }

    public function page() {
        return $this->belongsTo(Page::class, 'item_id', 'id');
    }

    public function urlMenu()
    {
        $url = '';
        if ($this->type == self::TYPE_CATEGORY) {
            $url = route('post.index')."?category=".$this->taxon->slug ?? '';
        }
        if ($this->type == self::TYPE_PAGE) {
            $url = route('page.show', $this->page->slug ?? '');
        }
        if ($this->type == self::TYPE_POST) {
            $url = route('post.show', $this->post->slug ?? '');
        }
        if ($this->type == self::TYPE_LINK) {
            $url = $this->item_content ?? '';
        }
        return $url;
    }
}
