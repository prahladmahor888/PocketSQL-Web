<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\DonationController as AdminDonationController;
use App\Http\Controllers\Admin\MessageController as AdminMessageController;
use App\Http\Controllers\Admin\ReleaseController as AdminReleaseController;
use App\Http\Controllers\Admin\SettingController as AdminSettingController;
use App\Http\Controllers\Admin\TrafficController as AdminTrafficController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\DocController;
use App\Http\Controllers\DonateController;
use App\Http\Controllers\DownloadController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\FeatureController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LegalController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public PocketSQL Web Application Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [AboutController::class, 'index'])->name('about');
Route::get('/features', [FeatureController::class, 'index'])->name('features');
Route::get('/docs', [DocController::class, 'index'])->name('docs');
Route::get('/download', [DownloadController::class, 'index'])->name('download');
Route::get('/download/apk/{release?}', [DownloadController::class, 'downloadApk'])->name('download.apk');
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'submit'])->middleware('throttle:5,1')->name('contact.submit');
Route::get('/donate', [DonateController::class, 'index'])->name('donate');
Route::post('/donate/order', [DonateController::class, 'createOrder'])->middleware('throttle:10,1')->name('donate.order');
Route::post('/donate/verify', [DonateController::class, 'verifyPayment'])->middleware('throttle:10,1')->name('donate.verify');
Route::get('/faq', [FaqController::class, 'index'])->name('faq');
Route::get('/privacy-policy', [LegalController::class, 'privacyPolicy'])->name('legal.privacy');
Route::get('/terms', [LegalController::class, 'termsOfService'])->name('legal.terms');
Route::get('/sitemap.xml', [HomeController::class, 'sitemap'])->name('sitemap');
Route::get('/robots.txt', [HomeController::class, 'robots'])->name('robots');

/*
|--------------------------------------------------------------------------
| Admin Panel & Authentication Routes
|--------------------------------------------------------------------------
*/

Route::get('/login', fn() => redirect()->route('admin.login'))->name('login');
Route::get('/admin', function () {
    return Auth::check() 
        ? redirect()->route('admin.dashboard') 
        : redirect()->route('admin.login');
})->name('admin');
Route::get('/admin/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login.submit');
Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

Route::prefix('admin')->middleware(['auth', 'admin.timeout'])->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    
    // Traffic Manager & Traffic Handler
    Route::get('/traffic', [AdminTrafficController::class, 'index'])->name('traffic.index');
    Route::post('/traffic/block-ip', [AdminTrafficController::class, 'blockIp'])->name('traffic.block_ip');
    Route::delete('/traffic/unblock-ip/{blockedIp}', [AdminTrafficController::class, 'unblockIp'])->name('traffic.unblock_ip');
    Route::post('/traffic/update-rules', [AdminTrafficController::class, 'updateRules'])->name('traffic.update_rules');
    Route::post('/traffic/clear-logs', [AdminTrafficController::class, 'clearLogs'])->name('traffic.clear_logs');
    Route::post('/traffic/reset-rate-limiters', [AdminTrafficController::class, 'resetRateLimiters'])->name('traffic.reset_rate_limiters');

    // Settings
    Route::get('/settings', [AdminSettingController::class, 'index'])->name('settings');
    Route::post('/settings', [AdminSettingController::class, 'update'])->name('settings.update');
    
    // Messages
    Route::get('/messages', [AdminMessageController::class, 'index'])->name('messages.index');
    Route::get('/messages/{message}', [AdminMessageController::class, 'show'])->name('messages.show');
    Route::patch('/messages/{message}/status', [AdminMessageController::class, 'updateStatus'])->name('messages.status');
    Route::match(['delete', 'post'], '/messages/{message}/delete', [AdminMessageController::class, 'destroy'])->name('messages.destroy.post');
    Route::match(['delete', 'post'], '/messages/{message}', [AdminMessageController::class, 'destroy'])->name('messages.destroy');
    
    // Releases
    Route::get('/releases', [AdminReleaseController::class, 'index'])->name('releases.index');
    Route::post('/releases', [AdminReleaseController::class, 'store'])->name('releases.store');
    Route::match(['delete', 'post'], '/releases/{release}/delete', [AdminReleaseController::class, 'destroy'])->name('releases.destroy.post');
    Route::match(['delete', 'post'], '/releases/{release}', [AdminReleaseController::class, 'destroy'])->name('releases.destroy');

    // Screenshots
    Route::get('/screenshots', [\App\Http\Controllers\Admin\ScreenshotController::class, 'index'])->name('screenshots.index');
    Route::post('/screenshots', [\App\Http\Controllers\Admin\ScreenshotController::class, 'store'])->name('screenshots.store');
    Route::patch('/screenshots/{screenshot}/toggle-featured', [\App\Http\Controllers\Admin\ScreenshotController::class, 'toggleFeatured'])->name('screenshots.toggle');
    Route::patch('/screenshots/{screenshot}/featured', [\App\Http\Controllers\Admin\ScreenshotController::class, 'toggleFeatured'])->name('screenshots.featured');
    Route::match(['delete', 'post'], '/screenshots/{screenshot}/delete', [\App\Http\Controllers\Admin\ScreenshotController::class, 'destroy'])->name('screenshots.destroy.post');
    Route::match(['delete', 'post'], '/screenshots/{screenshot}', [\App\Http\Controllers\Admin\ScreenshotController::class, 'destroy'])->name('screenshots.destroy');

    // Donations
    Route::get('/donations', [AdminDonationController::class, 'index'])->name('donations.index');
    Route::match(['delete', 'post'], '/donations/{donation}/delete', [AdminDonationController::class, 'destroy'])->name('donations.destroy.post');
    Route::match(['delete', 'post'], '/donations/{donation}', [AdminDonationController::class, 'destroy'])->name('donations.destroy');
});
