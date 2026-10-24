<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class GeoLocationService
{
    /**
     * Map of Indian full state names to standard postal abbreviations
     */
    protected static array $indianStateAbbreviations = [
        'Madhya Pradesh' => 'MP',
        'Uttar Pradesh' => 'UP',
        'Maharashtra' => 'MH',
        'Delhi' => 'DL',
        'National Capital Territory of Delhi' => 'DL',
        'NCT of Delhi' => 'DL',
        'Rajasthan' => 'RJ',
        'Gujarat' => 'GJ',
        'Karnataka' => 'KA',
        'Tamil Nadu' => 'TN',
        'Telangana' => 'TS',
        'Andhra Pradesh' => 'AP',
        'West Bengal' => 'WB',
        'Punjab' => 'PB',
        'Haryana' => 'HR',
        'Bihar' => 'BR',
        'Kerala' => 'KL',
        'Odisha' => 'OD',
        'Orissa' => 'OD',
        'Assam' => 'AS',
        'Jharkhand' => 'JH',
        'Chhattisgarh' => 'CG',
        'Uttarakhand' => 'UK',
        'Uttaranchal' => 'UK',
        'Himachal Pradesh' => 'HP',
        'Goa' => 'GA',
        'Jammu and Kashmir' => 'JK',
        'Chandigarh' => 'CH',
        'Puducherry' => 'PY',
        'Pondicherry' => 'PY',
        'Tripura' => 'TR',
        'Manipur' => 'MN',
        'Meghalaya' => 'ML',
        'Nagaland' => 'NL',
        'Mizoram' => 'MZ',
        'Sikkim' => 'SK',
        'Arunachal Pradesh' => 'AR',
        'Ladakh' => 'LA',
        'Dadra and Nagar Haveli and Daman and Diu' => 'DD',
    ];

    /**
     * Resolve reliable client IP from headers (supporting Cloudflare, Reverse Proxies)
     */
    public static function getClientIp(?Request $request = null): string
    {
        $request = $request ?? request();

        // 1. Cloudflare connecting IP
        if ($cfIp = $request->header('CF-Connecting-IP')) {
            $ip = trim(explode(',', $cfIp)[0]);
            if (filter_var($ip, FILTER_VALIDATE_IP)) {
                return $ip;
            }
        }

        // 2. True-Client-IP header
        if ($trueIp = $request->header('True-Client-IP')) {
            $ip = trim(explode(',', $trueIp)[0]);
            if (filter_var($ip, FILTER_VALIDATE_IP)) {
                return $ip;
            }
        }

        // 3. X-Forwarded-For header (first untrusted hop is original client)
        if ($xff = $request->header('X-Forwarded-For')) {
            $ips = explode(',', $xff);
            foreach ($ips as $ipCandidate) {
                $candidate = trim($ipCandidate);
                if (filter_var($candidate, FILTER_VALIDATE_IP)) {
                    return $candidate;
                }
            }
        }

        // 4. X-Real-IP header
        if ($realIp = $request->header('X-Real-IP')) {
            $ip = trim($realIp);
            if (filter_var($ip, FILTER_VALIDATE_IP)) {
                return $ip;
            }
        }

        return $request->ip() ?? '127.0.0.1';
    }

    /**
     * Check if an IP address is a private, loopback, or reserved address
     */
    public static function isPrivateIp(string $ip): bool
    {
        if (in_array($ip, ['127.0.0.1', '::1', '0.0.0.0', 'localhost'], true)) {
            return true;
        }

        return !filter_var(
            $ip,
            FILTER_VALIDATE_IP,
            FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE
        );
    }

    /**
     * Resolve GeoLocation details (City, State/Region, Country, Country Code)
     *
     * @param string $ip
     * @return array{city: ?string, region: ?string, country: ?string, countryCode: ?string}
     */
    public static function resolve(string $ip): array
    {
        $ip = trim($ip);

        // Handle private / localhost / internal testing
        if (self::isPrivateIp($ip)) {
            return Cache::remember('geoip_localhost_machine_loc', 86400, function () {
                try {
                    // Try to query the developer machine's current internet IP location
                    $response = Http::timeout(2)->get('http://ip-api.com/json/?fields=status,country,countryCode,region,regionName,city');
                    if ($response->successful() && $response->json('status') === 'success') {
                        $countryCode = strtoupper((string) $response->json('countryCode'));
                        $region = $response->json('region');
                        $regionName = $response->json('regionName');

                        $state = self::abbreviateState($regionName ?: $region, $countryCode);

                        return [
                            'city' => $response->json('city') ?: 'Gwalior',
                            'region' => $state ?: 'MP',
                            'country' => $response->json('country') ?: 'India',
                            'countryCode' => $countryCode ?: 'IN',
                        ];
                    }
                } catch (\Throwable $e) {
                    // Ignore network timeout in local test environment
                }

                // Default representative fallback for local development
                return [
                    'city' => 'Gwalior',
                    'region' => 'MP',
                    'country' => 'India',
                    'countryCode' => 'IN',
                ];
            });
        }

        // Handle Public Internet IP with 7-day Cache
        return Cache::remember("geoip_{$ip}", 86400 * 7, function () use ($ip) {
            try {
                // Primary Provider: ip-api.com
                $response = Http::timeout(2.5)->get("http://ip-api.com/json/{$ip}?fields=status,country,countryCode,region,regionName,city");
                if ($response->successful() && $response->json('status') === 'success') {
                    $countryCode = strtoupper((string) $response->json('countryCode'));
                    $regionName = (string) $response->json('regionName');
                    $regionCode = (string) $response->json('region');
                    $state = self::abbreviateState($regionName ?: $regionCode, $countryCode);

                    return [
                        'city' => $response->json('city'),
                        'region' => $state,
                        'country' => $response->json('country'),
                        'countryCode' => $countryCode,
                    ];
                }
            } catch (\Throwable $e) {
                // Fallback to secondary provider if primary fails
            }

            try {
                // Secondary Fallback Provider: ipwho.is
                $fallback = Http::timeout(2.5)->get("https://ipwho.is/{$ip}");
                if ($fallback->successful() && $fallback->json('success') === true) {
                    $countryCode = strtoupper((string) $fallback->json('country_code'));
                    $regionName = (string) $fallback->json('region');
                    $state = self::abbreviateState($regionName, $countryCode);

                    return [
                        'city' => $fallback->json('city'),
                        'region' => $state,
                        'country' => $fallback->json('country'),
                        'countryCode' => $countryCode,
                    ];
                }
            } catch (\Throwable $e) {
                // Both providers unavailable
            }

            return [
                'city' => null,
                'region' => null,
                'country' => null,
                'countryCode' => null,
            ];
        });
    }

    /**
     * Abbreviate state name if applicable (e.g., Madhya Pradesh -> MP)
     */
    public static function abbreviateState(?string $state, ?string $countryCode): ?string
    {
        if (empty($state)) {
            return null;
        }

        $cleanState = trim($state);

        if (strtoupper((string) $countryCode) === 'IN') {
            return self::$indianStateAbbreviations[$cleanState] ?? $cleanState;
        }

        return $cleanState;
    }

    /**
     * Format City, State, Country nicely (e.g., "Gwalior, MP, India")
     */
    public static function formatLocation(?string $city, ?string $state, ?string $country): string
    {
        $parts = [];
        if (!empty($city)) {
            $parts[] = trim($city);
        }
        if (!empty($state)) {
            $parts[] = trim($state);
        }
        if (!empty($country)) {
            $parts[] = trim($country);
        }

        if (empty($parts)) {
            return 'Unknown Location';
        }

        return implode(', ', $parts);
    }

    /**
     * Return FlagCDN image URL for given ISO-2 country code
     */
    public static function getFlagUrl(?string $countryCode): ?string
    {
        if (empty($countryCode) || strlen($countryCode) !== 2 || strtoupper($countryCode) === 'LO') {
            return null;
        }

        $code = strtolower($countryCode);
        return "https://flagcdn.com/24x18/{$code}.png";
    }

    /**
     * Return high-res 2x FlagCDN URL for crisp retina displays
     */
    public static function getFlagRetinaUrl(?string $countryCode): ?string
    {
        if (empty($countryCode) || strlen($countryCode) !== 2 || strtoupper($countryCode) === 'LO') {
            return null;
        }

        $code = strtolower($countryCode);
        return "https://flagcdn.com/48x36/{$code}.png";
    }

    /**
     * Convert 2-letter ISO country code into Unicode Flag Emoji
     */
    public static function getFlagEmoji(?string $countryCode): string
    {
        if (empty($countryCode) || strlen($countryCode) !== 2 || strtoupper($countryCode) === 'LO') {
            return '🌐';
        }

        $code = strtoupper($countryCode);
        return mb_chr(127397 + ord($code[0]), 'UTF-8') . mb_chr(127397 + ord($code[1]), 'UTF-8');
    }
}
