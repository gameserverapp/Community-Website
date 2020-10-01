<?php
$class = [];

$hasSubtitle = (isset($block['subtitle']) and !empty($block['subtitle'])) or isset($block['subtitle']);
$hasButton = (isset($block['button_text']) and !empty($block['button_text'])) or isset($block['button_text']);

if($hasSubtitle) {
    $class[] = 'with-subtitle';
} else {
    $class[] = 'no-subtitle';
}

if($hasButton) {
    $class[] = 'with-button';
} else {
    $class[] = 'no-button';
}
?>

<div class="big_banner">
    <div class="content-wrapper {{implode(' ', $class)}}">
        <h1>{{$value}}</h1>

        @if($hasSubtitle)
            <h2>{{$block['subtitle']}}</h2>
        @endif

        @if($hasButton)
            <div class="button-wrapper">
                <a href="{{$block['button_url']}}" class="btn btn-theme btn-theme-rock">
                    <span>{{$block['button_text']}}</span>
                </a>
            </div>
        @endif
    </div>
</div>