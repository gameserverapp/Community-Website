<?php

namespace GameserverApp\Helpers;


class RouteHelper extends Helper
{
    public static function isCurrentRoute($route, $args = false)
    {
        if (
            ! $args and
            app('request')->url() == route($route)
        ) {
            return true;
        }

        if (
            $args and
            app('request')->url() == route($route, $args)
        ) {
            return true;
        }

        return false;
    }

    public static function inspector()
    {
        return 'inspector';
    }

    public static function home()
    {
        $config = self::api()->domain('routes');

        if(isset( $config->home ) and !empty($config->home)) {
            return $config->home;
        }

        return false;
    }

    public static function support()
    {
        $config = self::api()->domain('routes');

        if(isset( $config->support )) {
            return $config->support;
        }

        return false;
    }

    public static function rules()
    {
        $config = self::api()->domain('routes');

        if(isset( $config->rules )) {
            return $config->rules;
        }

        return false;
    }
}