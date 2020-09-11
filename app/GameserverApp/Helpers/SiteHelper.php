<?php

namespace GameserverApp\Helpers;


use Illuminate\Support\Facades\Cookie;

class SiteHelper extends Helper
{

    public static function name()
    {
        return self::api()->domain('name');
    }

    public static function slug()
    {
        return self::api()->domain('slug');
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

    public static function customCssUrl()
    {
        return self::api()->domain('custom_css_url');
    }

    public static function customCss()
    {
        return self::api()->domain('custom_css');
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

    public static function googleFont()
    {
        return self::api()->domain('font', 'lato');
    }

    public static function googleFontsUrl()
    {
        return 'https://fonts.googleapis.com/css2?family=' . urlencode(self::googleFont()) . ':wght@100;300;500;700&display=swap';
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
        if(
            config('app.debug') and
            Cookie::has('override_theme') and
            Cookie::get('override_theme') != '0'
        ) {
            $theme = 'theme-' . Cookie::get('override_theme');
            $theme = str_replace('_', '-', $theme);
        } else {
            $theme = self::api()->domain('theme');
        }

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