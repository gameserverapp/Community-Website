<?php
$image = false;

if($item->hasImage()) {
    $image = $item->image();
}
?>

@extends('layouts.v3.default', [
    'page' => [
        'title' => $item->title(),
        'description' => $item->metaDescription(),
        'class' => 'article-single',
        'attributes' => '',
        'bg' => $image
    ],
    'microdata' => [
        'content' => 'itemscope itemtype="http://schema.org/Article"'
    ],
])

@section('page_content')

    <div class="row">
        <div class="col-md-12">
            <h1>{{$item->title()}}</h1>
            <time itemprop="datePublished" datetime="{{$item->date('published_at')->toDateTimeString()}}">{{$item->date('published_at')->format('j F Y')}}</time>
        </div>
    </div>

@stop