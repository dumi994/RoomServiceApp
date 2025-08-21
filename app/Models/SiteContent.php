<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteContent extends Model
{
    protected $table = 'site_content';
    protected $casts = [
        'home_bg_images' => 'array',
        'page_default_images' => 'array',
    ];
}
