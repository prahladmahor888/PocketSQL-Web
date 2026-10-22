@props([
    'type' => 'horizontal', // 'horizontal' or 'sidebar'
    'class' => ''
])

@php
    $adsEnabled = config('ads.enabled', true);
    if (!$adsEnabled) {
        return;
    }

    $isTestMode = config('ads.test_mode', false);
    $adsenseClient = config('ads.adsense.client_id');
    $adsenseSlot = ($type === 'sidebar') 
        ? config('ads.adsense.slot_sidebar') 
        : config('ads.adsense.slot_horizontal');

    // If client ID exists and test mode is off, treat as pure live AdSense
    $hasAdSenseConfig = !empty($adsenseClient) && !empty($adsenseSlot);
@endphp

@if($hasAdSenseConfig)
    {{-- ========================================================================= --}}
    {{-- 1. LIVE GOOGLE ADSENSE CODE (Official Google Tag)                         --}}
    {{-- ========================================================================= --}}
    @if($type === 'sidebar')
        <!-- Google AdSense Live Rectangle Sidebar Unit -->
        <div class="my-6 p-2 bg-slate-50/80 border border-slate-200/80 rounded-[10px] text-center overflow-hidden {{ $class }}">
            <div class="text-[9px] font-mono text-slate-400 uppercase tracking-wider mb-1 flex items-center justify-between px-1">
                <span class="flex items-center space-x-1">
                    <span class="text-blue-500 font-bold">G</span><span class="text-red-500 font-bold">o</span><span class="text-amber-500 font-bold">o</span><span class="text-blue-500 font-bold">g</span><span class="text-emerald-500 font-bold">l</span><span class="text-red-500 font-bold">e</span>
                    <span class="text-slate-500 font-medium">Ads</span>
                </span>
                <span class="text-[9px] text-slate-400">AdChoices &#9656;</span>
            </div>
            <ins class="adsbygoogle"
                 style="display:block;min-height:250px;"
                 data-ad-client="{{ $adsenseClient }}"
                 data-ad-slot="{{ $adsenseSlot }}"
                 data-ad-format="rectangle"
                 data-full-width-responsive="true"
                 @if($isTestMode) data-adtest="on" @endif></ins>
            <script>
                (adsbygoogle = window.adsbygoogle || []).push({});
            </script>
        </div>
    @else
        <!-- Google AdSense Live Horizontal Leaderboard Unit -->
        <div class="max-w-4xl mx-auto my-10 px-4 text-center {{ $class }}">
            <div class="p-2.5 bg-slate-50/80 border border-slate-200/80 rounded-[10px] overflow-hidden">
                <div class="text-[9px] font-mono text-slate-400 uppercase tracking-wider mb-1.5 flex items-center justify-between px-1">
                    <span class="flex items-center space-x-1">
                        <span class="text-blue-500 font-bold">G</span><span class="text-red-500 font-bold">o</span><span class="text-amber-500 font-bold">o</span><span class="text-blue-500 font-bold">g</span><span class="text-emerald-500 font-bold">l</span><span class="text-red-500 font-bold">e</span>
                        <span class="text-slate-500 font-medium">Ads</span>
                    </span>
                    <span class="text-[9px] text-slate-400">AdChoices &#9656;</span>
                </div>
                <ins class="adsbygoogle"
                     style="display:block;min-height:90px;"
                     data-ad-client="{{ $adsenseClient }}"
                     data-ad-slot="{{ $adsenseSlot }}"
                     data-ad-format="auto"
                     data-full-width-responsive="true"
                     @if($isTestMode) data-adtest="on" @endif></ins>
                <script>
                    (adsbygoogle = window.adsbygoogle || []).push({});
                </script>
            </div>
        </div>
    @endif

@else
    {{-- ========================================================================= --}}
    {{-- 2. GOOGLE ADSENSE PLACEHOLDER (When ADSENSE_CLIENT_ID is pending in .env) --}}
    {{-- ========================================================================= --}}
    @if($type === 'sidebar')
        <!-- Google AdSense Official 300x250 Medium Rectangle Unit Frame -->
        <div class="my-6 bg-slate-50 border border-slate-200 rounded-[10px] p-3 text-center space-y-3 relative overflow-hidden shadow-2xs {{ $class }}">
            <div class="flex items-center justify-between border-b border-slate-200 pb-1.5">
                <div class="flex items-center space-x-1 text-[11px] font-bold">
                    <span class="text-blue-600 font-black">Google</span>
                    <span class="text-slate-800 font-bold">AdSense</span>
                </div>
                <span class="text-[9px] font-mono text-slate-400 flex items-center space-x-1">
                    <span>Ads by Google</span>
                    <i class="fa-solid fa-circle-info text-[9px] text-blue-500"></i>
                </span>
            </div>

            <div class="py-6 flex flex-col items-center justify-center space-y-2 bg-white rounded-[8px] border border-dashed border-slate-200">
                <div class="w-10 h-10 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center text-lg">
                    <i class="fa-brands fa-google"></i>
                </div>
                <div class="space-y-0.5">
                    <span class="text-xs font-bold text-slate-800 block">Google AdSense Unit</span>
                    <span class="text-[10px] font-mono text-slate-400 uppercase tracking-wider block">Responsive 300 &times; 250</span>
                </div>
                <p class="text-[11px] text-slate-400 max-w-[200px] leading-tight">
                    Add your <code class="text-blue-600 bg-blue-50 px-1 py-0.5 rounded font-mono text-[10px]">ADSENSE_CLIENT_ID</code> in <code class="text-slate-700 bg-slate-100 px-1 py-0.5 rounded font-mono text-[10px]">.env</code> to display live ads.
                </p>
            </div>

            <div class="pt-1.5 border-t border-slate-100 text-[10px] font-mono text-slate-400 flex items-center justify-between">
                <span>google.com/adsense</span>
                <span class="text-blue-600 font-semibold">Ad Unit Ready</span>
            </div>
        </div>

    @else
        <!-- Google AdSense Official 728x90 Leaderboard Unit Frame -->
        <div class="max-w-4xl mx-auto my-10 px-4 {{ $class }}">
            <div class="bg-slate-50 border border-slate-200 rounded-[10px] p-3 sm:p-4 shadow-2xs relative overflow-hidden">
                <div class="flex items-center justify-between border-b border-slate-200 pb-2 mb-3">
                    <div class="flex items-center space-x-2">
                        <span class="w-2 h-2 rounded-full bg-blue-500"></span>
                        <div class="flex items-center space-x-1 text-xs font-bold">
                            <span class="text-blue-600 font-black">Google</span>
                            <span class="text-slate-800 font-bold">AdSense</span>
                        </div>
                        <span class="text-slate-300">|</span>
                        <span class="text-[11px] font-mono text-slate-500">Responsive Display Ad (728 &times; 90 Leaderboard)</span>
                    </div>
                    <div class="flex items-center space-x-1 text-[10px] font-mono text-slate-400">
                        <span>Ads by Google</span>
                        <i class="fa-solid fa-circle-info text-[9px] text-blue-500"></i>
                    </div>
                </div>

                <div class="py-5 px-4 bg-white rounded-[8px] border border-dashed border-slate-200 flex flex-col sm:flex-row items-center justify-between gap-4 text-center sm:text-left">
                    <div class="flex items-center space-x-3.5">
                        <div class="w-10 h-10 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center text-lg flex-shrink-0">
                            <i class="fa-brands fa-google"></i>
                        </div>
                        <div>
                            <h4 class="text-xs sm:text-sm font-bold text-slate-800">
                                Google AdSense Responsive Display Unit
                            </h4>
                            <p class="text-[11px] text-slate-400 mt-0.5">
                                Set <code class="text-blue-600 bg-blue-50 px-1 py-0.2 rounded font-mono text-[10px]">ADSENSE_CLIENT_ID</code> and <code class="text-blue-600 bg-blue-50 px-1 py-0.2 rounded font-mono text-[10px]">ADSENSE_SLOT_HORIZONTAL</code> in <code class="text-slate-700 bg-slate-100 px-1 py-0.2 rounded font-mono text-[10px]">.env</code> to serve live Google ads.
                            </p>
                        </div>
                    </div>
                    <div class="flex-shrink-0">
                        <span class="inline-flex items-center px-3 py-1.5 rounded-[8px] text-[11px] font-mono font-medium text-slate-600 bg-slate-100 border border-slate-200">
                            Status: Ready for Publisher ID
                        </span>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endif
