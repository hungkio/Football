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
        'from_team'
    ];

    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection('country')
            ->singleFile()
            ->useFallbackUrl('/backend/global_assets/images/placeholders/placeholder.jpg');
    }
}
