<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'current_version',
        'version_code',
        'apk_download_url',
        'playstore_url',
        'github_repo_url',
        'documentation_url',
        'contact_email',
        'release_notes',
        'api_server_active',
        'total_downloads_count',
        'traffic_shield_enabled',
        'rate_limit_per_minute',
        'admin_login_max_attempts',
        'admin_session_lifetime_minutes',
    ];

    protected $casts = [
        'api_server_active' => 'boolean',
        'version_code' => 'integer',
        'total_downloads_count' => 'integer',
        'traffic_shield_enabled' => 'boolean',
        'rate_limit_per_minute' => 'integer',
        'admin_login_max_attempts' => 'integer',
        'admin_session_lifetime_minutes' => 'integer',
    ];

    protected static function booted()
    {
        static::saved(function () {
            cache()->forget('app_setting_singleton');
            cache()->forget('home_page_data_v1');
            cache()->forget('download_page_data_v1');
            cache()->forget('faq_page_data_v1');
        });

        static::deleted(function () {
            cache()->forget('app_setting_singleton');
            cache()->forget('home_page_data_v1');
            cache()->forget('download_page_data_v1');
            cache()->forget('faq_page_data_v1');
        });
    }

    /**
     * Helper to get singleton setting instance (cached for ultra-fast response)
     */
    public static function instance(): self
    {
        return cache()->remember('app_setting_singleton', 300, function () {
            return static::firstOrCreate([], [
                'current_version' => 'v1.0.5',
                'version_code' => 11,
                'apk_download_url' => '/download/apk',
                'playstore_url' => 'https://play.google.com/store/apps/details?id=app.pocketsql.database',
                'github_repo_url' => 'https://github.com/pocketsql/pocketsql',
                'documentation_url' => '/docs',
                'contact_email' => 'support@pocketsql.prahlix.com',
                'release_notes' => 'PocketSQL v1.0.5 introduces native window functions, TLS 1.3 self-signed certificate generation on device, and 40+ MySQL system tables.',
                'api_server_active' => true,
                'total_downloads_count' => 1248, // Initial verified community baseline
                'traffic_shield_enabled' => true,
                'rate_limit_per_minute' => 120,
                'admin_login_max_attempts' => 3,
                'admin_session_lifetime_minutes' => 15,
            ]);
        });
    }
}
