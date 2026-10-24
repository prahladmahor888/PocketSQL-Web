<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AppSetting;
use App\Models\ContactMessage;
use App\Models\DonationMethod;
use App\Models\DownloadLog;
use App\Models\Release;
use App\Models\TrafficLog;
use App\Services\GeoLocationService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $settings = AppSetting::instance();
        $totalMessages = ContactMessage::count();
        $unreadMessages = ContactMessage::where('status', 'unread')->count();
        $totalReleases = Release::count();
        $activeDonations = DonationMethod::where('is_active', true)->count();
        $recentMessages = ContactMessage::orderBy('id', 'desc')->take(6)->get();

        // 1. Dynamic Downloads & Traffic Aggregation
        $totalDownloads = max(
            (int) Release::sum('downloads_count'),
            (int) DownloadLog::count(),
            (int) ($settings->total_downloads_count ?? 0)
        );

        $todayStart = now()->startOfDay();
        $todayRequests = TrafficLog::where('created_at', '>=', $todayStart)->count();
        $todayDownloads = DownloadLog::where('created_at', '>=', $todayStart)->count();
        $totalRequests = TrafficLog::count();

        // 2. 7-Day Chart Data Generation (Continuous Timeline)
        $days = 7;
        $startDate = now()->subDays($days - 1)->startOfDay();

        $trafficGrouped = TrafficLog::where('created_at', '>=', $startDate)
            ->select('created_at', 'ip_address')
            ->get()
            ->groupBy(fn($item) => $item->created_at ? $item->created_at->format('M d') : 'Unknown');

        $downloadsGrouped = DownloadLog::where('created_at', '>=', $startDate)
            ->select('created_at')
            ->get()
            ->groupBy(fn($item) => $item->created_at ? $item->created_at->format('M d') : 'Unknown');

        $chartLabels = [];
        $trafficCounts = [];
        $trafficUniqueIps = [];
        $downloadCounts = [];

        for ($i = $days - 1; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $label = $date->format('M d');
            $chartLabels[] = $label;

            $dayTraffic = $trafficGrouped->get($label, collect());
            $trafficCounts[] = $dayTraffic->count();
            $trafficUniqueIps[] = $dayTraffic->pluck('ip_address')->unique()->count();

            $dayDownloads = $downloadsGrouped->get($label, collect());
            $downloadCounts[] = $dayDownloads->count();
        }

        // 3. Top Countries for Traffic & Downloads
        $topTrafficCountries = TrafficLog::select('country', 'country_code', DB::raw('count(*) as count'))
            ->whereNotNull('country')
            ->groupBy('country', 'country_code')
            ->orderByDesc('count')
            ->limit(4)
            ->get();

        foreach ($topTrafficCountries as $tc) {
            $tc->flag_url = GeoLocationService::getFlagUrl($tc->country_code);
            $tc->flag_emoji = GeoLocationService::getFlagEmoji($tc->country_code);
        }

        $topDownloadCountries = DownloadLog::select('country', 'country_code', DB::raw('count(*) as count'))
            ->whereNotNull('country')
            ->groupBy('country', 'country_code')
            ->orderByDesc('count')
            ->limit(4)
            ->get();

        foreach ($topDownloadCountries as $dc) {
            $dc->flag_url = GeoLocationService::getFlagUrl($dc->country_code);
            $dc->flag_emoji = GeoLocationService::getFlagEmoji($dc->country_code);
        }

        return view('admin.dashboard', compact(
            'settings',
            'totalMessages',
            'unreadMessages',
            'totalReleases',
            'activeDonations',
            'recentMessages',
            'totalDownloads',
            'totalRequests',
            'todayRequests',
            'todayDownloads',
            'chartLabels',
            'trafficCounts',
            'trafficUniqueIps',
            'downloadCounts',
            'topTrafficCountries',
            'topDownloadCountries'
        ));
    }
}
