<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ToolMetaSeoLink extends Model
{
    public $guarded = [];
    protected $table = 'tool_meta_seo_link';

    
    public function transactions()
    {
        return $this->hasMany(ToolMetaSeoLinkTransaction::class, 'meta_seo_link_id');
    }
}
