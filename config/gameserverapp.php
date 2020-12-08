<?php
return [
    'connection' => [
        'url' => env('GSA_API_URL', 'https://dash.gameserverapp.com/api/v1/'),
        'client_id' => env('GSA_CLIENT_ID'),
        'client_secret' => env('GSA_CLIENT_SECRET'),
        'redirect' => env('GSA_REDIRECT_URL'),
        'timeout' => env('GSA_API_TIMEOUT', 20),

        'oauth_base_url' => env('GSA_OAUTH_BASE_URL', 'https://dash.gameserverapp.com/'),
    ],

    'main_site' => env('main_site', 'https://www.gameserverapp.com'),

    'cache' => [
        'default_cache_ttl' => env('DEFAULT_CACHE_TTL', 3 + floatval('0.0' . rand(1,9)) ),
        'get_user_ttl' => 0.5,
        'tribe_background' => 20
    ],

    'pagebuilder' => [
        'disable_vertical_align_for_blocks' => [
            'server_slider',
            'active_tribes',
            'newbies',
            'last_online',
            'top_players',
            'big_banner'
        ]
    ],

    'upload' => [
        'limit' => 500, //upload limit in KB
    ]
];