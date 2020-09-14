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