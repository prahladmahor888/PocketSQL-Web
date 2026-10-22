<?php

namespace App\Providers;

use App\Models\AppSetting;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Globally share dynamic database application settings and social links across all Blade views
        View::composer('*', function ($view) {
            try {
                $view->with('settings', AppSetting::instance());
                $view->with('activeSocialLinks', cache()->remember('active_social_links_v1', 3600, function () {
                    return \App\Models\SocialLink::where('is_active', true)->orderBy('sort_order')->get();
                }));
            } catch (\Throwable $e) {
                // Graceful fallback during early boot / migrations
            }
        });
    }
}
