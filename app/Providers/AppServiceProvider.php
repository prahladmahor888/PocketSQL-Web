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
        // Globally share dynamic database application settings across all Blade views
        View::composer('*', function ($view) {
            try {
                $view->with('settings', AppSetting::instance());
            } catch (\Throwable $e) {
                // Graceful fallback during early boot / migrations
            }
        });
    }
}
