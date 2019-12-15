<?php
return [
    'connection' => [
        'url' => env('GSA_API_URL', 'https://dash.gameserverapp.com/api/v1/'),
        'client_id' => env('GSA_CLIENT_ID'),
        'client_secret' => env('GSA_CLIENT_SECRET'),
        'redirect' => env('GSA_REDIRECT_URL'),
        'timeout' => env('GSA_API_TIMEOUT', 20)
    ],

    'cache' => [
        'default_cache_ttl' => env('DEFAULT_CACHE_TTL', 3 + floatval('0.0' . rand(1,9)) ),
        'get_user_ttl' => 0.5,
        'tribe_background' => 20
    ]
];