<?php
$height = 300;

if(isset($block['frame_height']) and !empty($block['frame_height'])) {
    $height = $block['frame_height'];
}

?>
@include('partials.frame.simple-top')
<div class="youtube">
    <iframe width="100%" height="{{$height}}" src="https://www.youtube.com/embed/{{$value}}?rel=0&amp;showinfo=0" frameborder="0" allowfullscreen></iframe>
</div>
@include('partials.frame.simple-bottom')