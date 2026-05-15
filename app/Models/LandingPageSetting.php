<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LandingPageSetting extends Model
{
    protected $fillable = ['title', 'description', 'slider_images'];

    protected $casts = [
        'slider_images' => 'array',
    ];
}
