<?php

use GameserverApp\Helpers\RichColor;
use GameserverApp\Helpers\SiteHelper;
use GuzzleHttp\Client;

function redirectBackWithAlert($msg, $status = 'success')
{
    return redirect()->back()->with([
        'alert' => [
            'status'  => $status,
            'message' => $msg
        ]
    ]);
}

function getRichColorClass($richcolor)
{
    $color = new RichColor($richcolor);
    return $color->getColorClass();
}

function isJson($string) {
    json_decode($string);
    return (json_last_error() == JSON_ERROR_NONE);
}

function mb_unserialize($string) {
    $string2 = preg_replace_callback(
        '!s:(\d+):"(.*?)";!s',
        function($m){
            $len = strlen($m[2]);
            $result = "s:$len:\"{$m[2]}\";";
            return $result;

        },
        $string);
    return unserialize($string2);
}

function in_array_any($needles, $haystack) {
    return !empty(array_intersect($needles, $haystack));
}

function calcPercentage($full, $calc)
{
    if($full == 0) {
        return 0;
    }

    return $calc*100/$full;
}

function alertOnSlack($data, $channel = 'bugsnag')
{
    try {
        $client = new Client([
            'base_uri' => 'https://slack.com',
            'timeout' => 5
        ]);

        if (is_array($data) or is_object($data)) {
            $data = json_encode($data);
        }

        $data = '[' . app()->environment() . '] - ' . $data;

        $response = $client->post(
            '/api/chat.postMessage',
            [
                'query' =>
                    [
                        'token'   => env('SLACK_API_TOKEN'),
                        'channel' => '#' . $channel,
                        'text'    => $data
                    ]
            ]
        );

        return json_decode($response->getBody());

    } catch( Exception $e) {
//        Bugsnag::notifyException($e);
    }
}

function translate($key, $default = '')
{
    return SiteHelper::translation($key, $default);
}

function themes() {
    return [
        'default',
        'aberration',
        'aberration-gold',
        'aberration-silver',
        'aberration-silver-red',
        'aberration-silver-green',
        'atlas-kraken',
        'extinction',
    ];
}

function getClosest($search, $arr) {
    $closest = null;
    foreach ($arr as $item) {
        if ($closest === null || abs($search - $closest) > abs($item - $search)) {
            $closest = $item;
        }
    }
    return $closest;
}

function getReached($search, $arr) {
    $closest = null;
    foreach ($arr as $item) {
        if ($search >= $item) {
            $closest = $item;
        }
    }

    return $closest;
}

function domain()
{
    $domain = strtolower(config('gameserverapp.oauthapi_domain', env('DOMAIN_OVERWRITE', app('request')->server('HTTP_HOST'))));

    if(app()->environment('local', 'test')) {
        $domain = str_replace(':444', '', $domain);
    }

    return $domain;
}

function color($key = 'primary-color')
{
    return SiteHelper::themeColors()->$key;
}

function graphColorTweak($graphData)
{
    if(isset($graphData->options->grid->backgroundColor)) {
        $graphData->options->grid->backgroundColor = 'transparent';
    }

    if(isset($graphData->options->lines)) {
        $graphData->options->lines = (object) [
            'show'      => true,
            'fill'      => true,
            'fillColor' => [
                'colors' => [
                    [
                        'opacity' => 0
                    ],
                    [
                        'opacity' => .4
                    ],
                ]
            ]
        ];
    }

    if(isset($graphData->data)) {

        $count = count($graphData->data);

        if($count > 5) {
            $graphData->options->legend->show = false;
        } elseif($count == 1) {
            $graphData->options->colors = [
                color('primary-color')
            ];
        }
    }

    return $graphData;
}