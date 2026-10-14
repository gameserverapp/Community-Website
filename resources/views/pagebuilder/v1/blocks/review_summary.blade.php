<?php
$settings = [];

if(isset($block['title']) and !empty($block['title'])) {
    $settings['title'] = $block['title'];
}
?>

<article class="review-summary">
    @component('partials.v3.frame', $settings)
        <div class="review-summary__content">
            {{$summary}}
        </div>
    @endcomponent
</article>