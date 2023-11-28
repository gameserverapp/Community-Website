<?php
$settings = [
    'class' => 'tiny-padding'
];

if(isset($title)) {
    $settings['title'] = $title;
}
?>

@component('partials.v3.frame', $settings)

    @if(
        isset($data['data']) and
        isset($data['options'])
    )
        <div class="stat_canvas"
             data-data='{!! json_encode($data['data']) !!}'
             data-options='{!!json_encode($data['options'])!!}'></div>
    @else
        <em>Failed to load data.</em>
    @endif
@endcomponent