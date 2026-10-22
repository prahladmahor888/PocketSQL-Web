<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SocialLink extends Model
{
    use HasFactory;

    protected $fillable = [
        'platform',
        'label',
        'url',
        'icon_svg',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    protected static function booted()
    {
        static::saved(function () {
            cache()->forget('active_social_links_v1');
        });

        static::deleted(function () {
            cache()->forget('active_social_links_v1');
        });
    }
}
