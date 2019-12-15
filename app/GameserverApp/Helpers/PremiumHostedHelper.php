<?php

namespace GameserverApp\Helpers;

use Illuminate\Database\DatabaseManager;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use GameserverApp\Api\OAuthApi;

class PremiumHostedHelper
{
    public static function redirectUrl()
    {
        if (! is_null(config('gameserverapp.connection.redirect'))) {
            return config('gameserverapp.connection.redirect');
        }

        return self::getConfig('redirect');
    }

    public static function clientId()
    {
        if (! is_null(config('gameserverapp.connection.client_id'))) {
            return config('gameserverapp.connection.client_id');
        }

        return self::getConfig('id');
    }

    public static function clientSecret()
    {
        if (! is_null(config('gameserverapp.connection.client_secret'))) {
            return config('gameserverapp.connection.client_secret');
        }

        return self::getConfig('secret');
    }

    public static function getActiveDomains()
    {
        return app(OAuthApi::class)->guestRequest('get', env('PREMIUM_GUI_API_DOMAIN_ENDPOINT'), [], -1);
    }

    private static function getConfig($column)
    {
        $client = app(OAuthApi::class)->guestRequest(
            'get',
            env('PREMIUM_GUI_API_CLIENT_ENDPOINT'),
            [],
            60
        );

        return $client->{$column};
    }
}