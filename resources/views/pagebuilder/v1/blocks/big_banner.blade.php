<?php
$class = [];

$hasSubtitle = (isset($block['subtitle']) and !empty($block['subtitle'])) or isset($block['subtitle']);
$hasLogo = (isset($block['logo']) and !empty($block['logo'])) or isset($block['logo']);
$hasButton = (isset($block['button_text']) and !empty($block['button_text'])) or isset($block['button_text']);

if($hasSubtitle) {
    $class[] = 'with-subtitle';
} else {
    $class[] = 'no-subtitle';
}

if($hasLogo) {
    $class[] = 'with-logo';
} else {
    $class[] = 'no-logo';
}

if($hasButton) {
    $class[] = 'with-button';
} else {
    $class[] = 'no-button';
}
?>

<div class="big_banner">
    <div class="content-wrapper {{implode(' ', $class)}}">

        @if($hasLogo)
            <img src="{{$block['logo']}}" alt="{{$value}}" style="width:auto; height:auto;">
        @else
            <h1>{{$value}}</h1>
        @endif

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