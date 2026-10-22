@props([
    'type' => 'horizontal', // 'horizontal' or 'sidebar'
    'class' => ''
])

@php
    // 1. Agar ads disabled hain toh kuch mat dikhao
    $adsEnabled = config('ads.enabled', true);
    if (!$adsEnabled) {
        return;
    }

    $adsenseClient = config('ads.adsense.client_id');
    $adsenseSlot = ($type === 'sidebar') 
        ? config('ads.adsense.slot_sidebar') 
        : config('ads.adsense.slot_horizontal');

    // 2. Jab tak .env me Client ID aur Slot ID na dali ho, bilkul kuch nahi dikhega (100% Clean)
    if (empty($adsenseClient) || empty($adsenseSlot)) {
        return;
    }

    $isTestMode = config('ads.test_mode', false);
@endphp

{{-- ========================================================================= --}}
{{-- OFFICIAL GOOGLE ADSENSE CODE (Sirf tab dikhega jab IDs .env me hongi)     --}}
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
