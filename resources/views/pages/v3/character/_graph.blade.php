<?php
$settings = [
    'class' => 'tiny-padding'
];

if(isset($title)) {
    $settings['title'] = $title;
}
?>

@component('partials.v3.frame', $settings)
    <div class="stat_canvas"
         data-data='{!! json_encode($data['data']) !!}'
         data-options='{!!json_encode($data['options'])!!}'></div>
@endcomponent