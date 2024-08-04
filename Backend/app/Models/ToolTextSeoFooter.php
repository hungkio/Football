<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ToolTextSeoFooter extends Model
{
    public $guarded = [];
    protected $table = 'tool_text_seo_footer';
    public function transactions()
    {
        return $this->hasMany(ToolMetaSeoLinkTransaction::class, 'text_seo_footer_id');
    }
}
