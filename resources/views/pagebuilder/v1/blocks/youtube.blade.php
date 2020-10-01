<?php
$height = 300;

if(isset($block['frame_height']) and !empty($block['frame_height'])) {
    $height = $block['frame_height'];
}

?>
@component('partials.v3.frame', ['class' => 'no-padding youtube no-bottom-margin', 'type' => 'basic'])
    <iframe width="100%" height="{{$height}}" src="https://www.youtube.com/embed/{{$value}}?rel=0&amp;showinfo=0" frameborder="0" allowfullscreen></iframe>
@endcomponent