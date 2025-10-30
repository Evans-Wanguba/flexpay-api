<?php
return [
    /*
    |--------------------------------------------------------------------------
    | Flexpay environment
    |--------------------------------------------------------------------------
    | base_url: production or staging
    */
    'base_url' => env('FLEXPAY_BASE_URL', 'https://staging.flexpay.co.ke'),
    'api_key' => env('FLEXPAY_API_KEY'),
    'api_secret' => env('FLEXPAY_API_SECRET'),
    'timeout' => env('FLEXPAY_TIMEOUT', 10),
    // endpoints (override if Flexpay changes paths)
    'endpoints' => [
        'book' => '/3Api/api/v1/book/flexpay/endpoint',
        'checkout_validation' => '/3Api/api/v1/booking/validation',
        'checkout_validation_online' => '/3Api/api/v1/booking/validation/online',
        'checkout_validate_otp' => '/3Api/api/v1/booking/validation/otp',
        'ipn' => '/3Api/api/v1/booking/validation/ipn',
    ],
];
