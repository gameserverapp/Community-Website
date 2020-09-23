<?php
$settings = [
    'settings' => 'tiny-padding no-bottom-margin'
];

if(isset($block['title']) and !empty($block['title'])) {
    $settings['title'] = $block['title'];
}
?>

@component('partials.v3.frame', $settings)
    <div class="stat_canvas" data-value="{{$value}}" data-route="{{route('stat.index', 'hours-played-last-7-days')}}"><span>Loading...</span></div>
@endcomponent