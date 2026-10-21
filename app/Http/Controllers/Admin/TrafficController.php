<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AppSetting;
use App\Models\BlockedIp;
use App\Models\TrafficLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\RateLimiter;

class TrafficController extends Controller
{
    /**
     * Display the Traffic Manager dashboard
     */
    public function index(Request $request)
    {
        $settings = AppSetting::instance();

        // 1. Core Analytics Metrics
        $todayStart = now()->startOfDay();
        $totalRequestsToday = TrafficLog::where('created_at', '>=', $todayStart)->count();
        $uniqueIpsToday = TrafficLog::where('created_at', '>=', $todayStart)->distinct('ip_address')->count('ip_address');
        $rateLimitedCount = TrafficLog::where('status_code', 429)->count();
        $blockedCount = BlockedIp::count();
        $avgResponseTime = (int) round(TrafficLog::where('created_at', '>=', now()->subHours(6))->avg('response_time_ms') ?? 0);

        // 2. Status Breakdown
        $status2xx = TrafficLog::where('status_code', '>=', 200)->where('status_code', '<', 300)->count();
        $status4xx = TrafficLog::where('status_code', '>=', 400)->where('status_code', '<', 500)->count();
        $status5xx = TrafficLog::where('status_code', '>=', 500)->count();

        // 3. Top Visited Paths
        $topPaths = TrafficLog::select('path', DB::raw('count(*) as count'))
            ->groupBy('path')
            ->orderByDesc('count')
            ->limit(5)
            ->get();

        // 4. Filtered Traffic Logs Table
        $logFilter = $request->input('filter', 'all');
        $logsQuery = TrafficLog::orderBy('id', 'desc');

        if ($logFilter === 'rate_limited') {
            $logsQuery->where('status_code', 429);
        } elseif ($logFilter === 'errors') {
            $logsQuery->where('status_code', '>=', 400);
        } elseif ($logFilter === 'success') {
            $logsQuery->where('status_code', '>=', 200)->where('status_code', '<', 300);
        }

        $trafficLogs = $logsQuery->limit(50)->get();

        // 5. Blocked IPs List
        $blockedIps = BlockedIp::orderBy('id', 'desc')->get();

        return view('admin.traffic', compact(
            'settings',
            'totalRequestsToday',
            'uniqueIpsToday',
            'rateLimitedCount',
            'blockedCount',
            'avgResponseTime',
            'status2xx',
            'status4xx',
            'status5xx',
            'topPaths',
            'trafficLogs',
            'blockedIps',
            'logFilter'
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

        // Also clear rate limiter key for that IP
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
     * Clear all recorded traffic logs
     */
    public function clearLogs()
    {
        TrafficLog::query()->delete();
        return back()->with('success', 'All traffic audit logs cleared successfully.');
    }

    /**
     * Reset active rate limiters
     */
    public function resetRateLimiters()
    {
        // Flush all traffic and login rate limit keys
        // In Laravel, rate limit keys are stored in cache
        try {
            cache()->flush();
        } catch (\Throwable $e) {
            // cache flush
        }

        return back()->with('success', 'Active Rate Limiter counters and temporary lockouts reset.');
    }
}
