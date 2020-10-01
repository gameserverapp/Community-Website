<?php
$height = 300;

if(isset($block['frame_height']) and !empty($block['frame_height'])) {
    $height = $block['frame_height'];
}

?>
@component('partials.v3.frame', ['class' => 'no-padding twitch no-bottom-margin', 'type' => 'basic'])
    <iframe
        src="https://player.twitch.tv/?channel={{$value}}&autoplay=false&muted=true&parent={{Request::getHost()}}"
        height="{{$height}}"
        width="100%"
        frameborder="0"
        scrolling="no"
        allowfullscreen="true">
    </iframe>
@endcomponent
