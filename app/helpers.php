<?php

use GameserverApp\Helpers\RichColor;

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