<?php

namespace App\Http\Middleware;

use App\Models\AppSetting;
use App\Models\BlockedIp;
use App\Models\TrafficLog;
use App\Services\DeviceDetectorService;
use App\Services\GeoLocationService;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\RateLimiter;
use Symfony\Component\HttpFoundation\Response;

class TrafficHandler
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $startTime = microtime(true);
        $ip = GeoLocationService::getClientIp($request);
        $path = '/' . ltrim($request->path(), '/');

        // Ignore asset paths from flooding traffic logs
        $isAsset = str_starts_with($path, '/build/') || 
                   str_starts_with($path, '/images/') || 
                   str_starts_with($path, '/favicon') ||
                   str_ends_with($path, '.css') ||
                   str_ends_with($path, '.js') ||
                   str_ends_with($path, '.png') ||
                   str_ends_with($path, '.jpg') ||
                   str_ends_with($path, '.jpeg') ||
                   str_ends_with($path, '.svg') ||
                   str_ends_with($path, '.ico') ||
                   str_ends_with($path, '.woff') ||
                   str_ends_with($path, '.woff2') ||
                   str_ends_with($path, '.map') ||
                   str_ends_with($path, '.webp');

        if ($isAsset) {
            $response = $next($request);
            $response->headers->set('Cache-Control', 'public, max-age=31536000, immutable');
            return $response;
        }

        $ua = $request->userAgent() ?? '';
        $isGoodSearchBot = $this->isVerifiedSearchBot($ua);

        $isLocal = ($ip === '127.0.0.1' || $ip === '::1');

        // 1. Exploit Probe Detection (Auto-Ban IP for 48 Hours)
        if ($exploitPattern = $this->isExploitProbe($path)) {
            if (!$isLocal) {
                BlockedIp::blockIp($ip, "Automated exploit probe: {$exploitPattern} ({$path})", 48);
            }
            $this->recordTrafficLog($ip, $request->method(), $path, 403, $ua, 0, true);

            return response()->view('errors.traffic-blocked', [
                'ip' => $ip,
                'message' => 'Security Alert: Automated exploit scan probe detected. Your IP has been blacklisted.',
            ], 403);
        }

        // 2. SQL Injection Inspection (Auto-Ban IP for 24 Hours)
        if ($sqliReason = $this->detectSqlInjection($request)) {
            if (!$isLocal) {
                BlockedIp::blockIp($ip, "SQL Injection attempt: {$sqliReason}", 24);
            }
            $this->recordTrafficLog($ip, $request->method(), $path, 403, $ua, 0, true);

            if ($request->expectsJson()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Security Alert: Malicious SQL injection sequence detected. Request blocked.',
                ], 403);
            }

            return response()->view('errors.traffic-blocked', [
                'ip' => $ip,
                'message' => 'Security Alert: Malicious SQL injection sequence detected. Access blocked.',
            ], 403);
        }

        // 3. Malicious Bot & Scraper Detection (Instant 403)
        if (!$isGoodSearchBot && ($botReason = $this->isMaliciousBot($request))) {
            $this->recordTrafficLog($ip, $request->method(), $path, 403, $ua, 0, true);

            if ($request->expectsJson()) {
                return response()->json([
                    'status' => 'error',
                    'message' => "Access Denied by PocketSQL Bot Shield: {$botReason}",
                ], 403);
            }

            return response()->view('errors.traffic-blocked', [
                'ip' => $ip,
                'message' => "Access Denied by PocketSQL Bot Shield: {$botReason}",
            ], 403);
        }

        // 3. IP Blacklist Check (Cached lookup)
        if (BlockedIp::isIpBlocked($ip)) {
            $this->recordTrafficLog($ip, $request->method(), $path, 403, $ua, 0, true);
            
            if ($request->expectsJson()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Access Denied: Your IP address has been restricted by PocketSQL Traffic Handler.',
                ], 403);
            }

            return response()->view('errors.traffic-blocked', [
                'ip' => $ip,
                'message' => 'Your IP address has been temporarily restricted by the PocketSQL Traffic Shield.',
            ], 403);
        }

        // 4. Traffic Shield & Rate Limiting
        $settings = AppSetting::instance();
        $trafficShieldEnabled = $settings->traffic_shield_enabled ?? true;
        // Search bots get generous allowance for fast indexing, others get configured limit
        $maxPerMinute = $isGoodSearchBot ? 300 : ($settings->rate_limit_per_minute ?? 120);

        $rateLimitKey = 'traffic:' . $ip;

        if ($trafficShieldEnabled) {
            if (RateLimiter::tooManyAttempts($rateLimitKey, $maxPerMinute)) {
                $seconds = RateLimiter::availableIn($rateLimitKey);
                $this->recordTrafficLog($ip, $request->method(), $path, 429, $ua, 0, false);

                if ($request->expectsJson()) {
                    return response()->json([
                        'status' => 'error',
                        'message' => "Too many requests. PocketSQL Traffic Handler rate limit triggered. Retry in {$seconds}s.",
                        'retry_after' => $seconds,
                    ], 429, ['Retry-After' => (string) $seconds]);
                }

                return response()->view('errors.rate-limited', [
                    'ip' => $ip,
                    'seconds' => $seconds,
                    'limit' => $maxPerMinute,
                ], 429, ['Retry-After' => (string) $seconds]);
            }

            RateLimiter::hit($rateLimitKey, 60);
        }

        // 5. Process Request
        $response = $next($request);

        // 6. Record Traffic Log
        $durationMs = (int) round((microtime(true) - $startTime) * 1000);
        $statusCode = $response->getStatusCode();

        $this->recordTrafficLog($ip, $request->method(), $path, $statusCode, $ua, $durationMs, false);

        // 7. Security & Performance Speed Headers
        $remaining = RateLimiter::remaining($rateLimitKey, $maxPerMinute);
        $response->headers->remove('X-Powered-By');
        $response->headers->set('X-Traffic-Handler', 'Active');
        $response->headers->set('X-Bot-Shield', 'Active');
        $response->headers->set('X-Content-Type-Options', 'nosniff');
        $response->headers->set('X-Frame-Options', 'SAMEORIGIN');
        $response->headers->set('X-XSS-Protection', '1; mode=block');
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');
        $response->headers->set('Permissions-Policy', 'camera=(), microphone=(), geolocation=()');
        $response->headers->set('Content-Security-Policy', "default-src 'self' https: data:; script-src 'self' 'unsafe-inline' 'unsafe-eval' https://cdnjs.cloudflare.com https://checkout.razorpay.com; style-src 'self' 'unsafe-inline' https://fonts.googleapis.com https://cdnjs.cloudflare.com; font-src 'self' https://fonts.gstatic.com https://cdnjs.cloudflare.com data:; img-src 'self' data: https: blob:; connect-src 'self' https://api.razorpay.com https://lumberjack.razorpay.com https://lumberjack-cx.razorpay.com; frame-src 'self' https://api.razorpay.com https://checkout.razorpay.com; child-src 'self' https://api.razorpay.com https://checkout.razorpay.com; frame-ancestors 'self';");

        if ($request->isSecure() || $request->header('X-Forwarded-Proto') === 'https') {
            $response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains; preload');
        }

        $response->headers->set('X-RateLimit-Limit', (string) $maxPerMinute);
        $response->headers->set('X-RateLimit-Remaining', (string) max(0, $remaining));

        // Browser caching for public GET pages (non-admin, non-auth)
        if ($request->isMethod('GET') && $statusCode === 200 && !str_starts_with($path, '/admin') && !str_starts_with($path, '/login')) {
            $response->headers->set('Cache-Control', 'public, max-age=120, stale-while-revalidate=300');
        }

        return $response;
    }

    /**
     * Check if user agent is a verified good search crawler
     */
    protected function isVerifiedSearchBot(string $ua): bool
    {
        $goodBots = [
            'googlebot',
            'bingbot',
            'slurp',
            'duckduckbot',
            'baiduspider',
            'yandexbot',
            'facebookexternalhit',
            'twitterbot',
            'linkedinbot',
            'applebot',
            'discordbot',
            'whatsapp',
        ];

        $lowerUa = strtolower($ua);
        foreach ($goodBots as $bot) {
            if (str_contains($lowerUa, $bot)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Detect known malicious bots, web scrapers, and vulnerability scanners
     */
    protected function isMaliciousBot(Request $request): ?string
    {
        // Allow in testing environment unless explicitly testing bad bot
        if (app()->environment('testing') && !$request->headers->has('X-Test-Bot')) {
            return null;
        }

        $ua = $request->userAgent();

        // 1. Empty or whitespace User-Agent on web requests
        if ($ua === null || trim($ua) === '') {
            return 'Missing or blank User-Agent header';
        }

        $lowerUa = strtolower($ua);

        // 2. Known attack scanners and exploit tools
        $scannerSignatures = [
            'sqlmap' => 'SQL injection scanner (sqlmap)',
            'nikto' => 'Web server scanner (nikto)',
            'masscan' => 'Port and banner scanner (masscan)',
            'dirbuster' => 'Directory brute-forcer (dirbuster)',
            'gobuster' => 'Directory brute-forcer (gobuster)',
            'wpscan' => 'CMS vulnerability scanner (wpscan)',
            'acunetix' => 'Vulnerability scanner (acunetix)',
            'havij' => 'Automated exploit tool (havij)',
            'nessus' => 'Vulnerability scanner (nessus)',
            'openvas' => 'Vulnerability scanner (openvas)',
            'nmap' => 'Network scanner (nmap)',
            'zgrab' => 'Internet scanner (zgrab)',
            'censys' => 'Scanning crawler (censys)',
            'shodan' => 'Port scanner (shodan)',
            'bytespider' => 'Aggressive bot crawler (bytespider)',
            'petalbot' => 'Aggressive scraping bot (petalbot)',
            'dotbot' => 'Aggressive scraping bot (dotbot)',
            'zoominfobot' => 'Data harvesting bot (zoominfobot)',
            'blexbot' => 'Rogue SEO crawler (blexbot)',
            'megaindex' => 'Aggressive scraper (megaindex)',
            'scrapy' => 'Python scraping framework (scrapy)',
            'aiohttp' => 'Automated python bot (aiohttp)',
            'libwww-perl' => 'Automated perl scraper (libwww-perl)',
        ];

        foreach ($scannerSignatures as $signature => $label) {
            if (str_contains($lowerUa, $signature)) {
                return $label;
            }
        }

        // 3. Raw python-requests trying to scrape without browser headers
        if (str_starts_with($lowerUa, 'python-requests') && !$request->expectsJson()) {
            return 'Automated Python scraper';
        }

        return null;
    }

    /**
     * Check if path matches known exploit scanning probes
     */
    protected function isExploitProbe(string $path): ?string
    {
        $lowerPath = strtolower($path);

        $exploitProbes = [
            '/.env',
            '/.git',
            '/.svn',
            '/.aws',
            '/wp-login',
            '/wp-admin',
            '/xmlrpc.php',
            '/phpinfo',
            '/phpmyadmin',
            '/pma',
            '/adminer',
            '/eval-stdin',
            '/actuator',
            '/shell.php',
            '/cgi-bin',
            '/autodiscover',
            '/vendor/phpunit',
        ];

        foreach ($exploitProbes as $probe) {
            if (str_contains($lowerPath, $probe)) {
                return $probe;
            }
        }

        return null;
    }

    /**
     * Record request to traffic_logs table
     */
    protected function recordTrafficLog(string $ip, string $method, string $path, int $status, ?string $ua, int $duration, bool $isBlocked): void
    {
        try {
            $location = GeoLocationService::resolve($ip);
            $device = DeviceDetectorService::parse($ua);

            TrafficLog::create([
                'ip_address' => $ip,
                'city' => $location['city'] ?? null,
                'state' => $location['region'] ?? null,
                'country' => $location['country'] ?? null,
                'country_code' => $location['countryCode'] ?? null,
                'device_type' => $device['device_type'] ?? null,
                'os' => $device['os'] ?? null,
                'browser' => $device['browser'] ?? null,
                'method' => substr($method, 0, 10),
                'path' => substr($path, 0, 500),
                'status_code' => $status,
                'user_agent' => $ua ? substr($ua, 0, 255) : null,
                'response_time_ms' => $duration,
                'is_blocked' => $isBlocked,
                'created_at' => now(),
            ]);

            // Auto-trim old logs if table exceeds 3,000 records
            if (rand(1, 100) === 1) {
                $count = TrafficLog::count();
                if ($count > 3000) {
                    $oldestId = TrafficLog::orderBy('id', 'desc')->skip(2500)->value('id');
                    if ($oldestId) {
                        TrafficLog::where('id', '<', $oldestId)->delete();
                    }
                }
            }
        } catch (\Throwable $e) {
            // Fail silently to never break user requests if logging fails
        }
    }

    /**
     * Comprehensive OWASP SQL Injection Detection Engine
     * Inspects URI paths, raw query strings, input payloads, JSON bodies, and headers.
     */
    protected function detectSqlInjection(Request $request): ?string
    {
        $sqliSignatures = [
            '/\bunion\s+(all\s+|distinct\s+)?select\b/i' => 'Union-based SQL injection',
            "/'\s*(or|and)\s*('|\d+=|true\b|1=1\b)/i" => 'Boolean-based SQL injection',
            '/\"\s*(or|and)\s*(\"|\d+=|true\b|1=1\b)/i' => 'Double-quote boolean SQL injection',
            '/\b(or|and)\s+1\s*=\s*1\b/i' => 'Tautology SQL injection',
            "/'\s*or\s*'[\w]+'\s*=\s*'[\w]+/i" => 'String tautology SQL injection',
            '/admin[\'"]\s*(\-\-|\#|\/\*)/i' => 'Admin auth bypass SQL comment',
            '/\b(sleep|benchmark|pg_sleep)\s*\(\s*\d+\s*\)/i' => 'Time-based blind SQL injection',
            '/\bwaitfor\s+delay\s+[\'"][\d:]+[\'"]/i' => 'MSSQL delay blind SQL injection',
            '/;\s*(drop|alter|truncate)\s+(table|database|schema)\b/i' => 'DDL destructive SQL injection',
            '/;\s*(insert\s+into|delete\s+from|update\s+[\w]+\s+set)\b/i' => 'Stacked query manipulation',
            '/\b(information_schema|performance_schema)\b/i' => 'Database schema enumeration',
            '/\b(schema_name|table_schema|column_name)\s*(=|like|in)\b/i' => 'Catalog enumeration SQL injection',
            '/\b(extractvalue|updatexml|gtid_subset)\s*\(/i' => 'Error-based XML SQL injection',
            '/\b(database|schema|system_user|current_user|version)\s*\(\s*\)/i' => 'System function footprinting',
            '/\b@@(version|version_compile_os|hostname|datadir|basedir)\b/i' => 'Database server variable footprinting',
            '/\b(load_file|into\s+outfile|into\s+dumpfile)\b/i' => 'Out-of-band file I/O SQL injection',
            '/\/\*![0-9]*[a-zA-Z]/i' => 'MySQL inline comment evasion attack',
            '/\bchar\s*\(\s*\d+\s*(,\s*\d+\s*)+\)/i' => 'Char encoded SQL injection vector',
        ];

        // 1. Inspect decoded URI path
        $decodedPath = rawurldecode($request->path());
        foreach ($sqliSignatures as $pattern => $label) {
            if (preg_match($pattern, $decodedPath)) {
                return "{$label} in URL path";
            }
        }

        // 2. Inspect raw and decoded query strings
        $rawQuery = (string) $request->server('QUERY_STRING', '');
        $decodedQuery = rawurldecode($rawQuery);
        foreach ($sqliSignatures as $pattern => $label) {
            if (($rawQuery !== '' && preg_match($pattern, $rawQuery)) ||
                ($decodedQuery !== '' && preg_match($pattern, $decodedQuery))) {
                return "{$label} in query string";
            }
        }

        // 3. Inspect raw request body (for raw JSON / XML / text payloads)
        $rawBody = (string) $request->getContent();
        if ($rawBody !== '' && strlen($rawBody) < 65536) {
            $decodedBody = rawurldecode($rawBody);
            foreach ($sqliSignatures as $pattern => $label) {
                if (preg_match($pattern, $rawBody) || preg_match($pattern, $decodedBody)) {
                    return "{$label} in request payload";
                }
            }
        }

        // 4. Recursively inspect all parsed input parameters & parameter keys
        $inputs = $request->except(['_token', 'password']);
        $flattened = $this->flattenInputsForSecurityScan($inputs);

        foreach ($flattened as $key => $value) {
            foreach ($sqliSignatures as $pattern => $label) {
                if (preg_match($pattern, $value) || preg_match($pattern, (string) $key)) {
                    return "{$label} in parameter [{$key}]";
                }
            }
        }

        return null;
    }

    /**
     * Recursively flatten multidimensional inputs for security scanning
     */
    protected function flattenInputsForSecurityScan(array $inputs, string $prefix = ''): array
    {
        $result = [];
        foreach ($inputs as $key => $value) {
            $fullKey = $prefix !== '' ? "{$prefix}.{$key}" : (string) $key;
            if (is_array($value)) {
                $result = array_merge($result, $this->flattenInputsForSecurityScan($value, $fullKey));
            } elseif (is_string($value) || is_numeric($value)) {
                $result[$fullKey] = (string) $value;
            }
        }
        return $result;
    }
}

