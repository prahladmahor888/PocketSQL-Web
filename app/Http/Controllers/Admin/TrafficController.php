<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AppSetting;
use App\Models\BlockedIp;
use App\Models\DownloadLog;
use App\Models\TrafficLog;
use App\Services\GeoLocationService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\RateLimiter;

class TrafficController extends Controller
{
    /**
     * Display the Traffic Manager & Analytics dashboard
     */
    public function index(Request $request)
    {
        $settings = AppSetting::instance();

        // 1. Date Range Filter
        $dateRange = $request->input('date_range', 'all');
        $dateFrom = $request->input('date_from');
        $dateTo = $request->input('date_to');

        $startDate = null;
        $endDate = null;

        if (!empty($dateFrom) && !empty($dateTo)) {
            try {
                $startDate = Carbon::parse($dateFrom)->startOfDay();
                $endDate = Carbon::parse($dateTo)->endOfDay();
                $dateRange = 'custom';
            } catch (\Throwable $e) {
                // Ignore parse errors
            }
        } elseif ($dateRange === 'today') {
            $startDate = now()->startOfDay();
            $endDate = now()->endOfDay();
        } elseif ($dateRange === 'yesterday') {
            $startDate = now()->subDay()->startOfDay();
            $endDate = now()->subDay()->endOfDay();
        } elseif ($dateRange === '7days') {
            $startDate = now()->subDays(6)->startOfDay();
            $endDate = now()->endOfDay();
        } elseif ($dateRange === '30days') {
            $startDate = now()->subDays(29)->startOfDay();
            $endDate = now()->endOfDay();
        } elseif ($dateRange === 'month') {
            $startDate = now()->startOfMonth();
            $endDate = now()->endOfMonth();
        }

        // Base Queries with Date Scope applied
        $trafficBase = TrafficLog::query();
        $downloadBase = DownloadLog::query();

        if ($startDate && $endDate) {
            $trafficBase->whereBetween('created_at', [$startDate, $endDate]);
            $downloadBase->whereBetween('created_at', [$startDate, $endDate]);
        }

        // 2. Core Metrics (Filtered)
        $totalRequests = (clone $trafficBase)->count();
        $uniqueIps = (clone $trafficBase)->distinct('ip_address')->count('ip_address');
        $rateLimitedCount = (clone $trafficBase)->where('status_code', 429)->count();
        $blockedCount = BlockedIp::count();
        $avgResponseTime = (int) round((clone $trafficBase)->avg('response_time_ms') ?? 0);

        // Today metrics for context
        $todayStart = now()->startOfDay();
        $totalRequestsToday = TrafficLog::where('created_at', '>=', $todayStart)->count();
        $uniqueIpsToday = TrafficLog::where('created_at', '>=', $todayStart)->distinct('ip_address')->count('ip_address');

        // 3. Country-Wise Traffic Request Totals
        $countryStats = (clone $trafficBase)
            ->select(
                'country',
                'country_code',
                DB::raw('count(*) as total_requests'),
                DB::raw('count(distinct ip_address) as unique_ips')
            )
            ->whereNotNull('country')
            ->groupBy('country', 'country_code')
            ->orderByDesc('total_requests')
            ->get();

        foreach ($countryStats as $stat) {
            $stat->percentage = $totalRequests > 0
                ? round(($stat->total_requests / $totalRequests) * 100, 1)
                : 0;
            $stat->flag_url = GeoLocationService::getFlagUrl($stat->country_code);
            $stat->flag_retina_url = GeoLocationService::getFlagRetinaUrl($stat->country_code);
            $stat->flag_emoji = GeoLocationService::getFlagEmoji($stat->country_code);
        }

        // 4. Country Chart Data (Chart.js ready)
        $chartColors = [
            '#3b82f6', '#10b981', '#f59e0b', '#8b5cf6', '#ec4899',
            '#06b6d4', '#f97316', '#6366f1', '#14b8a6', '#64748b'
        ];

        $chartLabels = [];
        $chartData = [];
        $topCountriesCount = 0;
        $otherRequestsCount = 0;

        foreach ($countryStats as $index => $stat) {
            if ($index < 6) {
                $chartLabels[] = ($stat->country ?: 'Unknown') . ' (' . ($stat->country_code ?: '--') . ')';
                $chartData[] = (int) $stat->total_requests;
                $topCountriesCount += $stat->total_requests;
            } else {
                $otherRequestsCount += $stat->total_requests;
            }
        }

        if ($otherRequestsCount > 0) {
            $chartLabels[] = 'Other Countries';
            $chartData[] = $otherRequestsCount;
        }

        // 5. Timeline Traffic Chart Data (grouped by day)
        $timelineLogs = (clone $trafficBase)->select('created_at')->orderBy('created_at', 'asc')->get();
        $timelineGrouped = $timelineLogs->groupBy(function ($item) {
            return $item->created_at ? $item->created_at->format('M d') : 'Unknown';
        });

        $timelineLabels = $timelineGrouped->keys()->toArray();
        $timelineData = $timelineGrouped->map(fn($g) => $g->count())->values()->toArray();

        // 6. APK Download Analytics (Filtered)
        $totalApkDownloads = (clone $downloadBase)->count();
        $apkDownloadsToday = DownloadLog::where('created_at', '>=', $todayStart)->count();
        $uniqueDownloadIps = (clone $downloadBase)->distinct('ip_address')->count('ip_address');

        // Country breakdown for APK Downloads
        $downloadCountryStats = (clone $downloadBase)
            ->select(
                'country',
                'country_code',
                DB::raw('count(*) as total_downloads'),
                DB::raw('count(distinct ip_address) as unique_ips')
            )
            ->whereNotNull('country')
            ->groupBy('country', 'country_code')
            ->orderByDesc('total_downloads')
            ->get();

        foreach ($downloadCountryStats as $stat) {
            $stat->percentage = $totalApkDownloads > 0
                ? round(($stat->total_downloads / $totalApkDownloads) * 100, 1)
                : 0;
            $stat->flag_url = GeoLocationService::getFlagUrl($stat->country_code);
            $stat->flag_retina_url = GeoLocationService::getFlagRetinaUrl($stat->country_code);
            $stat->flag_emoji = GeoLocationService::getFlagEmoji($stat->country_code);
        }

        // Top Download Locations (City / State / Country)
        $topDownloadLocations = (clone $downloadBase)
            ->select('city', 'state', 'country', 'country_code', DB::raw('count(*) as count'))
            ->whereNotNull('country')
            ->groupBy('city', 'state', 'country', 'country_code')
            ->orderByDesc('count')
            ->limit(5)
            ->get();

        // Top Download Devices
        $topDownloadDevices = (clone $downloadBase)
            ->select('device_type', 'os', DB::raw('count(*) as count'))
            ->whereNotNull('os')
            ->groupBy('device_type', 'os')
            ->orderByDesc('count')
            ->limit(5)
            ->get();

        // 7. Active Tab (traffic vs downloads)
        $activeTab = $request->input('tab', 'traffic');

        // 8. Filtered Web Traffic Logs Table
        $logFilter = $request->input('filter', 'all');
        $logsQuery = (clone $trafficBase)->orderBy('id', 'desc');

        if ($logFilter === 'rate_limited') {
            $logsQuery->where('status_code', 429);
        } elseif ($logFilter === 'errors') {
            $logsQuery->where('status_code', '>=', 400);
        } elseif ($logFilter === 'success') {
            $logsQuery->where('status_code', '>=', 200)->where('status_code', '<', 300);
        }

        $trafficLogs = $logsQuery->limit(50)->get();

        // 9. Filtered APK Download Logs Table
        $downloadSearch = trim((string) $request->input('dl_search', ''));
        $downloadQuery = (clone $downloadBase)->with('release')->orderBy('id', 'desc');

        if (!empty($downloadSearch)) {
            $downloadQuery->where(function ($q) use ($downloadSearch) {
                $q->where('ip_address', 'like', "%{$downloadSearch}%")
                    ->orWhere('city', 'like', "%{$downloadSearch}%")
                    ->orWhere('state', 'like', "%{$downloadSearch}%")
                    ->orWhere('country', 'like', "%{$downloadSearch}%")
                    ->orWhere('version', 'like', "%{$downloadSearch}%")
                    ->orWhere('os', 'like', "%{$downloadSearch}%")
                    ->orWhere('browser', 'like', "%{$downloadSearch}%");
            });
        }

        $downloadLogs = $downloadQuery->limit(50)->get();

        // 10. Blocked IPs List
        $blockedIps = BlockedIp::orderBy('id', 'desc')->get();

        return view('admin.traffic', compact(
            'settings',
            'totalRequests',
            'totalRequestsToday',
            'uniqueIps',
            'uniqueIpsToday',
            'rateLimitedCount',
            'blockedCount',
            'avgResponseTime',
            'countryStats',
            'chartLabels',
            'chartData',
            'chartColors',
            'timelineLabels',
            'timelineData',
            'totalApkDownloads',
            'apkDownloadsToday',
            'uniqueDownloadIps',
            'downloadCountryStats',
            'topDownloadLocations',
            'topDownloadDevices',
            'trafficLogs',
            'downloadLogs',
            'blockedIps',
            'logFilter',
            'activeTab',
            'downloadSearch',
            'dateRange',
            'dateFrom',
            'dateTo'
        ));
    }

    /**
     * Block an IP address manually
     */
    public function blockIp(Request $request)
    {
        $validated = $request->validate([
            'ip_address' => 'required|ip',
            'reason' => 'nullable|string|max:255',
            'duration_hours' => 'nullable|integer|min:0|max:8760',
        ]);

        $ip = trim($validated['ip_address']);

        // Don't allow blocking localhost to prevent admin accidental self-lockout
        if (in_array($ip, ['127.0.0.1', '::1', $request->ip()])) {
            return back()->with('error', "Safety Violation: Cannot restrict current administrative IP ({$ip}).");
        }

        $blockedUntil = null;
        if (!empty($validated['duration_hours']) && $validated['duration_hours'] > 0) {
            $blockedUntil = now()->addHours((int) $validated['duration_hours']);
        }

        BlockedIp::updateOrCreate(
            ['ip_address' => $ip],
            [
                'reason' => $validated['reason'] ?? 'Manually restricted by Administrator',
                'blocked_until' => $blockedUntil,
            ]
        );

        return back()->with('success', "IP Address [{$ip}] restricted successfully by Traffic Handler.");
    }

    /**
     * Unblock an IP address
     */
    public function unblockIp(BlockedIp $blockedIp)
    {
        $ip = $blockedIp->ip_address;
        $blockedIp->delete();

        RateLimiter::clear('traffic:' . $ip);

        return back()->with('success', "Restriction removed for IP [{$ip}]. Traffic restored.");
    }

    /**
     * Update Traffic Handler & Rate Limiter thresholds
     */
    public function updateRules(Request $request)
    {
        $validated = $request->validate([
            'traffic_shield_enabled' => 'nullable|boolean',
            'rate_limit_per_minute' => 'required|integer|min:10|max:1000',
            'admin_login_max_attempts' => 'required|integer|min:1|max:10',
            'admin_session_lifetime_minutes' => 'required|integer|min:2|max:1440',
        ]);

        $settings = AppSetting::instance();
        $settings->update([
            'traffic_shield_enabled' => $request->boolean('traffic_shield_enabled'),
            'rate_limit_per_minute' => $validated['rate_limit_per_minute'],
            'admin_login_max_attempts' => $validated['admin_login_max_attempts'],
            'admin_session_lifetime_minutes' => $validated['admin_session_lifetime_minutes'],
        ]);

        return back()->with('success', 'Traffic Handler rules & Rate Limiter policies updated successfully.');
    }

    /**
     * Clear all recorded web traffic logs
     */
    public function clearLogs()
    {
        TrafficLog::query()->delete();
        return back()->with('success', 'All web traffic audit logs cleared successfully.');
    }

    /**
     * Clear recorded APK download logs
     */
    public function clearDownloadLogs()
    {
        DownloadLog::query()->delete();
        return back()->with('success', 'All APK download tracking logs cleared successfully.');
    }

    /**
     * Reset active rate limiters
     */
    public function resetRateLimiters()
    {
        try {
            cache()->flush();
        } catch (\Throwable $e) {
            // cache flush
        }

        return back()->with('success', 'Active Rate Limiter counters and temporary lockouts reset.');
    }
}
