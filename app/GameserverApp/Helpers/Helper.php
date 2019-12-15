<?php

namespace GameserverApp\Helpers;

use GameserverApp\Api\Client;

class Helper
{
    protected static function api()
    {
        return app(Client::class);
    }
}