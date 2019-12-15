<?php

namespace GameserverApp\Helpers;


class SiteHelper extends Helper
{

    public static function name()
    {
        return self::api()->domain('name');
    }

    public static function footerDescription()
    {
        return self::api()->domain('content')->footer->description;
    }

    public static function footerLinks($block = false)
    {
        $links = self::api()->domain('content')->footer->links;

        if ($block) {
            return $links->{$block};
        }

        return $links;
    }

    public static function customCss()
    {
        return self::api()->domain('custom_css_url');
    }

    public static function customMenuItems()
    {
        return self::api()->domain('custom_menu');
    }

    public static function featureEnabled($key)
    {
        $features = self::api()->domain('features');

        if(!isset($features->$key)) {
            return false;
        }

        return $features->$key;
    }

    public static function seoDescription()
    {
        return str_limit(self::footerDescription(), 100, '...');
    }

    public static function googleFontsUrl()
    {
        return 'https://fonts.googleapis.com/css?family=Righteous|Lato:100,300,700';
    }

    public static function googleAnalyticsId()
    {
        return self::api()->domain('google_analytics_id');
    }

    public static function hotjarId()
    {
        return self::api()->domain('hotjar_id');
    }

    public static function background()
    {
        return self::api()->domain('background');
    }

    public static function favicon()
    {
        return self::api()->domain('favicon');
    }

    public static function theme()
    {
        $theme = self::api()->domain('theme');

        if($theme != 'theme-default') {
            $theme = 'theme-basic ' . $theme;
        }

        return $theme;
    }

    public static function groupName()
    {
        switch(self::api()->domain('theme')) {
//            case 'theme-aberration':
//            case 'theme-aberration_gold':
//            case 'theme-aberration_silver':
//            case 'theme-extinction':
//                return 'tribe';
//
//            case 'theme-atlas-kraken':
//                return 'company';

            default:
                return 'group';
        }
    }

    public static function navigationType()
    {
        return 'layouts.v2.default.navs.default';
    }
}