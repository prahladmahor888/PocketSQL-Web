@props([
    'type' => 'horizontal', // 'horizontal' or 'sidebar'
    'class' => ''
])

@php
    $adsEnabled = config('ads.enabled', true);
    if (!$adsEnabled) {
        return;
    }

    $isTestMode = config('ads.test_mode', true);
    $provider = config('ads.provider', 'adsense');
    $adsenseClient = config('ads.adsense.client_id');
    $adsenseSlot = ($type === 'sidebar') 
        ? config('ads.adsense.slot_sidebar') 
        : config('ads.adsense.slot_horizontal');

    // Dynamic Sponsor Values from config / .env
    $sponsorUrl = config('ads.sponsor.url', 'https://www.hostinger.com/vps-hosting');
    $horizontalTitle = config('ads.sponsor.horizontal_title', 'Fast Cloud Database & VPS Hosting for Developers');
    $horizontalDesc = config('ads.sponsor.horizontal_desc', '1-click deployment for MySQL, PostgreSQL, Docker, and Redis with ultra-low latency & 99.9% uptime.');
    $horizontalBtn = config('ads.sponsor.horizontal_button', 'Get Started →');

    $sidebarTitle = config('ads.sponsor.sidebar_title', 'High-Speed NVMe Cloud VPS');
    $sidebarDesc = config('ads.sponsor.sidebar_desc', 'Host Python, Node.js & MySQL databases with dedicated root access & 300 Mb/s port.');
    $sidebarBadge = config('ads.sponsor.sidebar_badge', 'Deploy from $4.99/mo');
@endphp

{{-- ========================================================================= --}}
{{-- 1. TEST MODE ACTIVE: Renders Visual Google AdSense Test Ad Mockup         --}}
{{-- ========================================================================= --}}
@if($isTestMode)
    @if($type === 'sidebar')
        <!-- Google AdSense Visual Test Ad: 300x250 Medium Rectangle Unit -->
        <div class="bg-gradient-to-br from-amber-50/60 via-white to-slate-50 border-2 border-dashed border-amber-300 rounded-[10px] p-4 text-center space-y-3 relative overflow-hidden shadow-2xs {{ $class }}">
            <div class="flex items-center justify-between border-b border-amber-200/80 pb-2">
                <span class="inline-flex items-center space-x-1.5 text-[11px] font-bold text-slate-700">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-ping"></span>
                    <span class="text-blue-600 font-extrabold">Google</span><span class="text-slate-800">AdSense</span>
                </span>
                <span class="px-2 py-0.5 rounded-[6px] bg-amber-400 text-amber-950 text-[10px] font-mono font-bold uppercase tracking-wider">
                    Test Mode
                </span>
            </div>

            <div class="py-2 space-y-2 text-left">
                <span class="text-[10px] font-mono text-slate-400 uppercase tracking-wider block">Responsive 300×250 Slot</span>
                <h5 class="text-xs font-bold text-slate-900 line-clamp-1">
                    {{ $sidebarTitle }}
                </h5>
                <p class="text-[11px] text-slate-500 leading-snug line-clamp-2">
                    {{ $sidebarDesc }}
                </p>
                <a href="{{ $sponsorUrl }}" target="_blank" rel="noopener" class="inline-flex items-center justify-center w-full py-1.5 px-3 rounded-[6px] text-xs font-bold bg-blue-600 text-white hover:bg-blue-700 transition shadow-2xs mt-1">
                    <span>{{ $sidebarBadge }}</span>
                </a>
            </div>

            <div class="pt-2 border-t border-dashed border-amber-200 text-[10px] font-mono text-slate-400 flex items-center justify-between">
                <span>ADS_TEST_MODE=true</span>
                <span class="text-emerald-600 font-semibold">Active Preview</span>
            </div>
        </div>

    @else
        <!-- Google AdSense Visual Test Ad: Responsive 728x90 Leaderboard Unit -->
        <div class="max-w-4xl mx-auto my-10 px-4 {{ $class }}">
            <div class="bg-gradient-to-r from-amber-50/60 via-white to-slate-50 border-2 border-dashed border-amber-300 rounded-[10px] p-4 sm:p-5 relative overflow-hidden shadow-2xs">
                
                <div class="flex items-center justify-between border-b border-amber-200/80 pb-2.5 mb-3">
                    <div class="flex items-center space-x-2">
                        <span class="w-2 h-2 rounded-full bg-emerald-500 animate-ping"></span>
                        <span class="text-xs font-extrabold text-blue-600">Google <span class="text-slate-800 font-bold">AdSense</span></span>
                        <span class="text-slate-300">|</span>
                        <span class="text-[11px] font-mono text-slate-500 font-medium">Responsive 728×90 Leaderboard Unit</span>
                    </div>
                    <span class="px-2 py-0.5 rounded-[6px] bg-amber-400 text-amber-950 text-[10px] font-mono font-bold uppercase tracking-wider">
                        Test Mode Active
                    </span>
                </div>

                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div class="flex items-center space-x-3.5">
                        <div class="w-11 h-11 rounded-[8px] bg-amber-500 text-white flex items-center justify-center font-bold text-lg flex-shrink-0 shadow-2xs">
                            <i class="fa-solid fa-rectangle-ad"></i>
                        </div>
                        <div>
                            <h4 class="text-sm font-bold text-slate-900">
                                {{ $horizontalTitle }}
                            </h4>
                            <p class="text-xs text-slate-500 line-clamp-1 sm:line-clamp-none">
                                {{ $horizontalDesc }}
                            </p>
                        </div>
                    </div>

                    <div class="flex-shrink-0">
                        <a href="{{ $sponsorUrl }}" target="_blank" rel="noopener" 
                           class="inline-flex items-center justify-center px-4 py-2 text-xs font-bold rounded-[8px] text-white bg-slate-900 hover:bg-blue-600 transition shadow-2xs whitespace-nowrap">
                            <span>{{ $horizontalBtn }}</span>
                        </a>
                    </div>
                </div>

                <div class="mt-3 pt-2 border-t border-dashed border-amber-200 text-[10px] font-mono text-slate-400 flex flex-wrap items-center justify-between gap-1">
                    <span>💡 Live preview rendered because <code class="text-amber-800 bg-amber-100 px-1 rounded">ADS_TEST_MODE=true</code> in .env</span>
                    <span class="text-slate-500">To switch to real ads, set <code class="text-slate-800 bg-slate-200 px-1 rounded">ADS_TEST_MODE=false</code></span>
                </div>
            </div>
        </div>
    @endif

{{-- ========================================================================= --}}
{{-- 2. PRODUCTION LIVE ADS: Google AdSense (When Approved & Configured)       --}}
{{-- ========================================================================= --}}
@elseif($provider === 'adsense' && !empty($adsenseClient) && !empty($adsenseSlot))
    @if($type === 'sidebar')
        <!-- Google AdSense Live Rectangle Sidebar Unit -->
        <div class="p-2.5 bg-slate-50 border border-slate-200 rounded-[10px] text-center overflow-hidden {{ $class }}">
            <div class="text-[9px] font-mono text-slate-400 uppercase tracking-wider mb-1.5 flex items-center justify-between">
                <span>Advertisement</span>
                <span>Ad</span>
            </div>
            <ins class="adsbygoogle"
                 style="display:block"
                 data-ad-client="{{ $adsenseClient }}"
                 data-ad-slot="{{ $adsenseSlot }}"
                 data-ad-format="rectangle"
                 data-full-width-responsive="true"></ins>
            <script>
                (adsbygoogle = window.adsbygoogle || []).push({});
            </script>
        </div>
    @else
        <!-- Google AdSense Live Horizontal Responsive Leaderboard Unit -->
        <div class="max-w-4xl mx-auto my-10 px-4 text-center {{ $class }}">
            <div class="p-3 bg-slate-50 border border-slate-200 rounded-[10px] overflow-hidden">
                <div class="text-[9px] font-mono text-slate-400 uppercase tracking-wider mb-1.5 flex items-center justify-between">
                    <span>Advertisement</span>
                    <span>Ad</span>
                </div>
                <ins class="adsbygoogle"
                     style="display:block"
                     data-ad-client="{{ $adsenseClient }}"
                     data-ad-slot="{{ $adsenseSlot }}"
                     data-ad-format="auto"
                     data-full-width-responsive="true"></ins>
                <script>
                    (adsbygoogle = window.adsbygoogle || []).push({});
                </script>
            </div>
        </div>
    @endif

{{-- ========================================================================= --}}
{{-- 3. CUSTOM DEVELOPER SPONSOR / AFFILIATE ADS                               --}}
{{-- ========================================================================= --}}
@else
    @if($type === 'sidebar')
        <!-- Dynamic Developer Sidebar Ad Unit (Carbon / 300x250 Style) -->
        <div class="p-3.5 bg-slate-50 border border-slate-200 rounded-[10px] space-y-2.5 transition hover:border-slate-300 {{ $class }}">
            <div class="flex items-center justify-between text-[10px] font-mono text-slate-400 uppercase tracking-wider">
                <span>Sponsored</span>
                <span class="hover:text-slate-600 transition cursor-help" title="Sponsored Developer Link">Ad</span>
            </div>

            <a href="{{ $sponsorUrl }}" target="_blank" rel="noopener sponsored" class="block group">
                <div class="flex items-start space-x-3">
                    <div class="w-10 h-10 rounded-[8px] bg-indigo-600 text-white flex items-center justify-center font-bold text-sm flex-shrink-0 group-hover:scale-105 transition-transform shadow-2xs">
                        <i class="fa-solid fa-server"></i>
                    </div>
                    <div class="space-y-1">
                        <div class="text-xs font-bold text-slate-900 group-hover:text-blue-600 transition line-clamp-1">
                            {{ $sidebarTitle }}
                        </div>
                        <p class="text-[11px] text-slate-500 leading-snug line-clamp-2">
                            {{ $sidebarDesc }}
                        </p>
                    </div>
                </div>
                <div class="mt-2.5 pt-2 border-t border-slate-200/60 flex items-center justify-between text-[11px] font-semibold text-blue-600 group-hover:text-blue-700">
                    <span>{{ $sidebarBadge }}</span>
                    <span class="transition-transform group-hover:translate-x-0.5">&rarr;</span>
                </div>
            </a>
        </div>

    @else
        <!-- Dynamic Horizontal Mid-Content Ad Banner (Responsive 728x90 Style) -->
        <div class="max-w-4xl mx-auto my-12 px-4 {{ $class }}">
            <div class="bg-gradient-to-r from-slate-50 via-white to-slate-50 border border-slate-200 rounded-[10px] p-4 sm:p-5 shadow-2xs transition hover:border-slate-300 relative overflow-hidden">
                <div class="flex items-center justify-between text-[10px] font-mono text-slate-400 uppercase tracking-wider mb-2">
                    <span class="flex items-center space-x-1">
                        <i class="fa-solid fa-rectangle-ad text-slate-400"></i>
                        <span>Sponsored Developer Tool</span>
                    </span>
                    <span class="text-slate-400 hover:text-slate-600 transition cursor-help" title="Sponsored Advertisement">Ad</span>
                </div>

                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div class="flex items-center space-x-3.5">
                        <div class="w-11 h-11 rounded-[8px] bg-blue-600 text-white flex items-center justify-center font-bold text-lg flex-shrink-0 shadow-2xs">
                            <i class="fa-solid fa-database"></i>
                        </div>
                        <div>
                            <h4 class="text-sm font-bold text-slate-900">
                                {{ $horizontalTitle }}
                            </h4>
                            <p class="text-xs text-slate-500 line-clamp-1 sm:line-clamp-none">
                                {{ $horizontalDesc }}
                            </p>
                        </div>
                    </div>

                    <div class="flex-shrink-0">
                        <a href="{{ $sponsorUrl }}" target="_blank" rel="noopener sponsored" 
                           class="inline-flex items-center justify-center px-4 py-2 text-xs font-bold rounded-[8px] text-white bg-slate-900 hover:bg-blue-600 transition shadow-2xs active:scale-95 whitespace-nowrap">
                            <span>{{ $horizontalBtn }}</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endif
