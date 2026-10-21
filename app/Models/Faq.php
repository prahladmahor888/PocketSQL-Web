<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    use HasFactory;

    protected $fillable = [
        'question',
        'answer',
        'category',
        'sort_order',
    ];

    protected $casts = [
        'sort_order' => 'integer',
    ];

    protected static function booted()
    {
        static::saved(function () {
            cache()->forget('home_page_data_v1');
            cache()->forget('faq_page_data_v1');
        });

        static::deleted(function () {
            cache()->forget('home_page_data_v1');
            cache()->forget('faq_page_data_v1');
        });
    }
}
