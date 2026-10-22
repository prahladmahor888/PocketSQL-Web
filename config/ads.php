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
    'provider' => env('ADS_PROVIDER', 'adsense'),

    /*
    |--------------------------------------------------------------------------
    | Google AdSense Settings
    |--------------------------------------------------------------------------
    | Slot IDs and Publisher ID for official Google AdSense integration.
    */
    'adsense' => [
        'client_id' => env('ADSENSE_CLIENT_ID', ''),
        'slot_horizontal' => env('ADSENSE_SLOT_HORIZONTAL', ''),
        'slot_sidebar' => env('ADSENSE_SLOT_SIDEBAR', ''),
    ],

];
