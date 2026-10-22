<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-white antialiased">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @php
        $pageTitle = isset($title) 
            ? (str_contains($title, 'PocketSQL') ? $title : $title . ' — PocketSQL')
            : 'PocketSQL — Run Native SQL Database & REST API Server on Android (Zero Root)';
        $pageDescription = $description ?? 'PocketSQL is the official high-performance Android SQL database engine and background REST/TLS API server. Execute SQL queries with zero root, microsecond latency, and 100% offline security. Download official APK or install via Google Play.';
        $pageKeywords = $keywords ?? 'PocketSQL, pocketsql, pocketsql android, pocketsql apk, pocketsql download, android sql database, run mysql on android, android rest api server, offline sql database, zero root sqlite server, termux mysql alternative, mobile sql server, android database daemon, sqlite android terminal';
        
        $currentUrl = url()->current();
        $siteUrl = url('/');
        $currentRoute = Route::currentRouteName() ?? 'home';
        
        // Structured Breadcrumbs
        $breadcrumbsList = [
            [
                '@type' => 'ListItem',
                'position' => 1,
                'name' => 'Home',
                'item' => $siteUrl
            ]
        ];
        if ($currentRoute !== 'home') {
            $pageName = ucwords(str_replace(['.', '-', '_'], ' ', $currentRoute));
            $breadcrumbsList[] = [
                '@type' => 'ListItem',
                'position' => 2,
                'name' => $pageName,
                'item' => $currentUrl
            ];
        }

        // Base JSON-LD Graph
        $jsonLdGraph = [
            [
                '@type' => 'SoftwareApplication',
                '@id' => $siteUrl . '#software',
                'name' => 'PocketSQL',
                'alternateName' => ['Pocket SQL', 'PocketSQL Android', 'PocketSQL Database Engine', 'PocketSQL Server'],
                'operatingSystem' => 'Android 10, Android 11, Android 12, Android 13, Android 14, Android 15',
                'applicationCategory' => 'DeveloperApplication',
                'applicationSubCategory' => 'DatabaseEngine',
                'description' => 'PocketSQL is an embedded native SQL database engine with an interactive terminal CLI and persistent background HTTP/TLS REST API server for Android devices. Zero root required.',
                'offers' => [
                    '@type' => 'Offer',
                    'price' => '0',
                    'priceCurrency' => 'USD',
                    'availability' => 'https://schema.org/InStock'
                ],
                'aggregateRating' => [
                    '@type' => 'AggregateRating',
                    'ratingValue' => '4.9',
                    'ratingCount' => '1280',
                    'bestRating' => '5',
                    'worstRating' => '1'
                ],
                'downloadUrl' => route('download.apk'),
                'installUrl' => $settings->playstore_url ?? 'https://play.google.com/store/apps/details?id=app.pocketsql.database',
                'softwareVersion' => $settings->current_version ?? 'v1.0.5',
                'fileSize' => $settings->apk_size ?? '12.4 MB',
                'author' => [
                    '@type' => 'Organization',
                    'name' => 'PocketSQL Open Source Project',
                    'url' => $siteUrl
                ],
                'featureList' => [
                    'Zero Root Required — runs completely in Android user space',
                    'Persistent Background HTTP/TLS REST API Server on Port 8080',
                    'Full SQL Execution with multi-table JOINs and Window Functions',
                    '40+ MySQL Information Schema Emulated System Tables',
                    'Interactive Terminal SQL Console with Live Syntax Highlighting',
                    '100% Offline-First Zero Cloud Telemetry Engine'
                ]
            ],
            [
                '@type' => 'WebSite',
                '@id' => $siteUrl . '#website',
                'url' => $siteUrl,
                'name' => 'PocketSQL',
                'alternateName' => 'PocketSQL Official Portal',
                'description' => 'Official portal and release hub for PocketSQL: Embedded SQL Database & Background API Server for Android.',
                'publisher' => [
                    '@type' => 'Organization',
                    'name' => 'PocketSQL Open Source Project',
                    'url' => $siteUrl,
                    'logo' => [
                        '@type' => 'ImageObject',
                        'url' => asset('images/logo.png')
                    ]
                ]
            ],
            [
                '@type' => 'BreadcrumbList',
                '@id' => $currentUrl . '#breadcrumbs',
                'itemListElement' => $breadcrumbsList
            ]
        ];

        // Optional FAQ Schema if provided by view
        if (isset($faqItems) && is_iterable($faqItems) && count($faqItems) > 0) {
            $faqQuestions = [];
            foreach ($faqItems as $item) {
                $faqQuestions[] = [
                    '@type' => 'Question',
                    'name' => $item->question ?? $item['question'],
                    'acceptedAnswer' => [
                        '@type' => 'Answer',
                        'text' => strip_tags($item->answer ?? $item['answer'])
                    ]
                ];
            }
            $jsonLdGraph[] = [
                '@type' => 'FAQPage',
                '@id' => $currentUrl . '#faq',
                'mainEntity' => $faqQuestions
            ];
        }
    @endphp

    <title>{{ $pageTitle }}</title>
    <meta name="description" content="{{ $pageDescription }}">
    <meta name="keywords" content="{{ $pageKeywords }}">
    <meta name="author" content="PocketSQL Core Engineering Team">
    <meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1">
    <link rel="canonical" href="{{ $currentUrl }}">
    <meta name="theme-color" content="#2563eb">
    <meta name="application-name" content="PocketSQL">

    <!-- OpenGraph / Facebook / LinkedIn Meta Tags -->
    <meta property="og:site_name" content="PocketSQL">
    <meta property="og:locale" content="en_US">
    <meta property="og:title" content="{{ $pageTitle }}">
    <meta property="og:description" content="{{ $pageDescription }}">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ $currentUrl }}">
    <meta property="og:image" content="{{ asset('images/logo.png') }}">
    <meta property="og:image:width" content="512">
    <meta property="og:image:height" content="512">
    <meta property="og:image:alt" content="PocketSQL — Embedded SQL Database & REST API Server for Android">

    <!-- Twitter Card Meta Tags -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:site" content="@PocketSQLApp">
    <meta name="twitter:creator" content="@PocketSQLApp">
    <meta name="twitter:title" content="{{ $pageTitle }}">
    <meta name="twitter:description" content="{{ $pageDescription }}">
    <meta name="twitter:image" content="{{ asset('images/logo.png') }}">

    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">

    @if(config('ads.enabled') && config('ads.provider') === 'adsense' && !empty(config('ads.adsense.client_id')))
        <!-- Google AdSense Official Script (Loaded via .env) -->
        <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client={{ config('ads.adsense.client_id') }}" crossorigin="anonymous"></script>
    @endif

    <!-- Schema.org JSON-LD Structured Data for Google Rich Snippets -->
    <script type="application/ld+json">
    {!! json_encode([
      '@context' => 'https://schema.org',
      '@graph' => $jsonLdGraph
    ], JSON_UNESCAPED_SLASHES | JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT | JSON_PRETTY_PRINT) !!}
    </script>

    <!-- Google Fonts: Poppins & JetBrains Mono -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;500;600;700&family=Poppins:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,400;1,600&display=swap" rel="stylesheet">

    <!-- Local Compiled Tailwind CSS & Font Awesome Icons via Vite Bundle -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Strict 10px border-radius & Alpine.js cloak enforcement -->
    <style>
        [x-cloak] {
            display: none !important;
        }
        *, ::before, ::after {
            --tw-border-spacing-x: 0;
            --tw-border-spacing-y: 0;
        }
        .rounded-10, button, input, select, textarea, .card-box {
            border-radius: 10px !important;
        }
    </style>
</head>
<body class="min-h-full flex flex-col bg-white text-slate-800 font-sans selection:bg-blue-600 selection:text-white" x-data>

    <!-- Top Announcement Bar (Server Online / Version) -->
    <div class="bg-slate-900 text-white text-xs py-2 px-4 border-b border-slate-800">
        <div class="max-w-7xl mx-auto flex flex-wrap items-center justify-between gap-2">
            <div class="flex items-center space-x-2">
                <span class="inline-flex items-center px-2 py-0.5 rounded-[10px] text-[11px] font-semibold bg-emerald-500/20 text-emerald-400 border border-emerald-500/30">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse mr-1.5"></span>
                    {{ $settings->current_version }} Released
                </span>
                <span class="text-slate-300 hidden sm:inline">Android 10 - 15 Ready • Zero Root Required</span>
            </div>
            <div class="flex items-center space-x-4 text-slate-300 text-xs">
                <a href="{{ route('docs') }}" class="hover:text-white transition flex items-center">
                    <span>API Docs</span>
                    <svg class="w-3.5 h-3.5 ml-1 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
                <span class="text-slate-600">•</span>
                <a href="{{ route('donate') }}" class="text-blue-400 hover:text-blue-300 font-medium transition">Sponsor Open Source</a>
            </div>
        </div>
    </div>

    <!-- Navigation Bar Component -->
    <x-navbar />

    <!-- Flash Notifications -->
    @if(session('success') || session('error'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full mt-4">
            @if(session('success'))
                <div class="mb-4 p-4 rounded-[10px] bg-emerald-50 border border-emerald-200 text-emerald-800 flex items-start justify-between shadow-sm" x-data="{ show: true }" x-show="show">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-emerald-600 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <p class="text-sm font-medium">{{ session('success') }}</p>
                    </div>
                    <button type="button" @click="show = false" class="text-emerald-600 hover:text-emerald-900 ml-4">
                        <span class="text-xl leading-none">&times;</span>
                    </button>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-4 p-4 rounded-[10px] bg-red-50 border border-red-200 text-red-800 flex items-start justify-between shadow-sm" x-data="{ show: true }" x-show="show">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-red-600 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <p class="text-sm font-medium">{{ session('error') }}</p>
                    </div>
                    <button type="button" @click="show = false" class="text-red-600 hover:text-red-900 ml-4">
                        <span class="text-xl leading-none">&times;</span>
                    </button>
                </div>
            @endif
        </div>
    @endif

    <!-- Main Page Content -->
    <main class="flex-grow">
        {{ $slot }}
    </main>

    <!-- Footer Component -->
    <x-footer />

</body>
</html>
