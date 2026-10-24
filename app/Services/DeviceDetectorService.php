<?php

namespace App\Services;

class DeviceDetectorService
{
    /**
     * Parse User-Agent string into Device Type, OS, Browser, and icon metadata
     *
     * @param string|null $userAgent
     * @return array{
     *     device_type: string,
     *     os: string,
     *     browser: string,
     *     device_icon: string,
     *     os_icon: string,
     *     browser_icon: string,
     *     label: string,
     *     badge_class: string
     * }
     */
    public static function parse(?string $userAgent): array
    {
        if (empty($userAgent)) {
            return [
                'device_type' => 'Unknown',
                'os' => 'Unknown OS',
                'browser' => 'Unknown',
                'device_icon' => 'fa-solid fa-question text-slate-400',
                'os_icon' => 'fa-solid fa-desktop text-slate-400',
                'browser_icon' => 'fa-solid fa-globe text-slate-400',
                'label' => 'Unknown Device',
                'badge_class' => 'bg-slate-100 text-slate-600 border-slate-200',
            ];
        }

        $ua = $userAgent;

        // 1. Detect Bots / Automated Crawlers
        if (preg_match('/(googlebot|bingbot|yandexbot|duckduckbot|baiduspider|slurp|facebookexternalhit|twitterbot|rogerbot|linkedinbot|embedly|quora link preview|showyoubot|outbrain|pinterest\/0\.|pinterestbot|slackbot|vkshare|w3c_validator|whatsapp|curl|wget|python-requests|guzzlehttp|postmanruntime)/i', $ua, $matches)) {
            $botName = ucfirst($matches[1]);
            return [
                'device_type' => 'Bot',
                'os' => 'Bot / Crawler',
                'browser' => $botName,
                'device_icon' => 'fa-solid fa-robot text-purple-600',
                'os_icon' => 'fa-solid fa-robot text-purple-600',
                'browser_icon' => 'fa-solid fa-robot text-purple-600',
                'label' => "Bot • {$botName}",
                'badge_class' => 'bg-purple-50 text-purple-700 border-purple-200',
            ];
        }

        // 2. Detect Operating System & OS Icon
        $os = 'Unknown OS';
        $osIcon = 'fa-solid fa-desktop text-slate-500';

        if (preg_match('/Android\s*([0-9.]+)?/i', $ua, $m)) {
            $version = !empty($m[1]) ? ' ' . $m[1] : '';
            $os = "Android{$version}";
            $osIcon = 'fa-brands fa-android text-emerald-600';
        } elseif (preg_match('/(iPhone|iPad|iPod)/i', $ua)) {
            if (preg_match('/OS\s*([0-9_]+)/i', $ua, $m)) {
                $ver = str_replace('_', '.', $m[1]);
                $os = "iOS {$ver}";
            } else {
                $os = 'iOS';
            }
            $osIcon = 'fa-brands fa-apple text-slate-800';
        } elseif (preg_match('/Windows NT 10\.0/i', $ua)) {
            // Windows NT 10.0 covers Windows 10 & Windows 11
            $os = 'Windows 11/10';
            $osIcon = 'fa-brands fa-windows text-blue-600';
        } elseif (preg_match('/Windows NT 6\.3/i', $ua)) {
            $os = 'Windows 8.1';
            $osIcon = 'fa-brands fa-windows text-blue-500';
        } elseif (preg_match('/Windows NT 6\.1/i', $ua)) {
            $os = 'Windows 7';
            $osIcon = 'fa-brands fa-windows text-blue-500';
        } elseif (preg_match('/Windows/i', $ua)) {
            $os = 'Windows';
            $osIcon = 'fa-brands fa-windows text-blue-600';
        } elseif (preg_match('/Macintosh|Mac OS X/i', $ua)) {
            $os = 'macOS';
            $osIcon = 'fa-brands fa-apple text-slate-700';
        } elseif (preg_match('/Linux/i', $ua)) {
            $os = 'Linux';
            $osIcon = 'fa-brands fa-linux text-amber-600';
        } elseif (preg_match('/CrOS/i', $ua)) {
            $os = 'ChromeOS';
            $osIcon = 'fa-brands fa-chrome text-blue-500';
        }

        // 3. Detect Device Type & Device Icon
        $deviceType = 'Desktop';
        $deviceIcon = 'fa-solid fa-laptop text-slate-600';

        if (preg_match('/(tablet|ipad|playbook|silk)|(android(?!.*mobile))/i', $ua)) {
            $deviceType = 'Tablet';
            $deviceIcon = 'fa-solid fa-tablet-screen-button text-purple-600';
        } elseif (preg_match('/(mobile|iphone|ipod|blackberry|iemobile|opera mini|windows phone|dalvik)/i', $ua) || str_contains($ua, 'Android')) {
            $deviceType = 'Mobile';
            $deviceIcon = 'fa-solid fa-mobile-screen text-blue-600';
        }

        // 4. Detect Browser / HTTP Client & Browser Icon
        $browser = 'Unknown';
        $browserIcon = 'fa-solid fa-globe text-slate-500';

        if (preg_match('/(AndroidDownloadManager|okhttp|Dalvik)/i', $ua, $m)) {
            $browser = 'Android Package Manager';
            $browserIcon = 'fa-solid fa-download text-emerald-600';
        } elseif (preg_match('/SamsungBrowser\/([0-9.]+)/i', $ua, $m)) {
            $browser = 'Samsung Internet';
            $browserIcon = 'fa-solid fa-globe text-blue-600';
        } elseif (preg_match('/Edg[eA]?\/([0-9.]+)/i', $ua, $m)) {
            $browser = 'Edge';
            $browserIcon = 'fa-brands fa-edge text-blue-600';
        } elseif (preg_match('/OPR\/([0-9.]+)|Opera/i', $ua, $m)) {
            $browser = 'Opera';
            $browserIcon = 'fa-brands fa-opera text-red-600';
        } elseif (preg_match('/Chrome\/([0-9.]+)/i', $ua, $m)) {
            $browser = 'Chrome';
            $browserIcon = 'fa-brands fa-chrome text-yellow-600';
        } elseif (preg_match('/Firefox\/([0-9.]+)/i', $ua, $m)) {
            $browser = 'Firefox';
            $browserIcon = 'fa-brands fa-firefox-browser text-orange-600';
        } elseif (preg_match('/Safari\/([0-9.]+)/i', $ua, $m) && !str_contains($ua, 'Chrome')) {
            $browser = 'Safari';
            $browserIcon = 'fa-brands fa-safari text-blue-500';
        } elseif (preg_match('/UCBrowser\/([0-9.]+)/i', $ua, $m)) {
            $browser = 'UC Browser';
            $browserIcon = 'fa-solid fa-globe text-orange-500';
        }

        // 5. Badge class
        $badgeClass = match ($deviceType) {
            'Mobile' => 'bg-blue-50 text-blue-700 border-blue-200',
            'Tablet' => 'bg-purple-50 text-purple-700 border-purple-200',
            'Desktop' => 'bg-slate-50 text-slate-700 border-slate-200',
            default => 'bg-slate-100 text-slate-600 border-slate-200',
        };

        // Formatted friendly label
        $label = "{$os} • {$browser}";
        if ($os === 'Unknown OS' && $browser !== 'Unknown') {
            $label = "{$deviceType} ({$browser})";
        } elseif ($browser === 'Unknown' && $os !== 'Unknown OS') {
            $label = $os;
        }

        return [
            'device_type' => $deviceType,
            'os' => $os,
            'browser' => $browser,
            'device_icon' => $deviceIcon,
            'os_icon' => $osIcon,
            'browser_icon' => $browserIcon,
            'label' => $label,
            'badge_class' => $badgeClass,
        ];
    }
}
