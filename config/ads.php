<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Advertisement Master Switch & Test Mode
    |--------------------------------------------------------------------------
    | Set enabled to false in .env to disable all advertisements site-wide.
    | Set test_mode to true in .env to preview Google AdSense Test Ad units.
    */
    'enabled' => env('ADS_ENABLED', true),
    'test_mode' => env('ADS_TEST_MODE', true),

    /*
    |--------------------------------------------------------------------------
    | Ad Provider
    |--------------------------------------------------------------------------
    | Supported options: "custom", "adsense"
    */
    'provider' => env('ADS_PROVIDER', 'custom'),

    /*
    |--------------------------------------------------------------------------
    | Google AdSense Settings
    |--------------------------------------------------------------------------
    | When provider is set to "adsense", these slots are rendered.
    */
    'adsense' => [
        'client_id' => env('ADSENSE_CLIENT_ID', ''),
        'slot_horizontal' => env('ADSENSE_SLOT_HORIZONTAL', ''),
        'slot_sidebar' => env('ADSENSE_SLOT_SIDEBAR', ''),
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Developer Sponsor & Affiliate Settings
    |--------------------------------------------------------------------------
    | Used when provider is "custom" or as fallback. Configurable via .env.
    */
    'sponsor' => [
        'url' => env('AD_SPONSOR_URL', 'https://www.hostinger.com/vps-hosting'),
        'horizontal_title' => env('AD_SPONSOR_HORIZONTAL_TITLE', 'Fast Cloud Database & VPS Hosting for Developers'),
        'horizontal_desc' => env('AD_SPONSOR_HORIZONTAL_DESC', '1-click deployment for MySQL, PostgreSQL, Docker, and Redis with ultra-low latency & 99.9% uptime.'),
        'horizontal_button' => env('AD_SPONSOR_HORIZONTAL_BUTTON', 'Get Started →'),
        'sidebar_title' => env('AD_SPONSOR_SIDEBAR_TITLE', 'High-Speed NVMe Cloud VPS'),
        'sidebar_desc' => env('AD_SPONSOR_SIDEBAR_DESC', 'Host Python, Node.js & MySQL databases with dedicated root access & 300 Mb/s port.'),
        'sidebar_badge' => env('AD_SPONSOR_SIDEBAR_BADGE', 'Deploy from $4.99/mo'),
    ],

];
