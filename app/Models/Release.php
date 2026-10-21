<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Release extends Model
{
    use HasFactory;

    protected $fillable = [
        'version',
        'version_code',
        'release_date',
        'apk_size',
        'sha256_hash',
        'changelog',
        'download_url',
        'downloads_count',
        'is_latest',
    ];

    protected $casts = [
        'is_latest' => 'boolean',
        'version_code' => 'integer',
        'downloads_count' => 'integer',
    ];

    protected static function booted()
    {
        static::saved(function () {
            cache()->forget('home_page_data_v1');
            cache()->forget('download_page_data_v1');
        });

        static::deleted(function () {
            cache()->forget('home_page_data_v1');
            cache()->forget('download_page_data_v1');
        });
    }

    public function downloadLogs()
    {
        return $this->hasMany(DownloadLog::class);
    }
}
