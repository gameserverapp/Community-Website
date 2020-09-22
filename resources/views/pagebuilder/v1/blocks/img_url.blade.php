<?php
$width = '100%';
$height = 'auto';

if(isset($block['width']) and !empty($block['width'])) {
    $width = $block['width'];
}

if(isset($block['height']) and !empty($block['height'])) {
    $height = $block['height'];
}
?>

@component('partials.v3.frame', ['class' => 'no-padding img', 'type' => 'basic'])
    <img width="{{$width}}" height="{{$height}}" src="{{$value}}">
@endcomponent