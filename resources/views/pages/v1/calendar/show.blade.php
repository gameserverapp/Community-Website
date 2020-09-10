<?php
$banner = [
    'size' => 'small',
    'vertical-align' => true
];

if($post->hasImage()) {
    $banner['background']['img'] = $post->image();
    $banner['class'] = 'custom_bg';
}
?>

@extends('layouts.v2.banner', [
    'page' => [
        'title' => $post->title(),
        'description' => $post->metaDescription(),
        'class' => 'news show',
        'attributes' => ''
    ],
    'microdata' => [
        'content' => 'itemscope itemtype="http://schema.org/Article"'
    ],
    'banner' => $banner
])

@section('banner_content')
    <div class="col-md-8 text-only center-block">

        <h1>
            <span itemprop="headline">{!! $post->title() !!}</span>
            <br>
            <small>
                <time itemprop="datePublished" datetime="{{$post->date('published_at')->toDateTimeString()}}">{{$post->date('published_at')->format('j F Y')}}</time>
            </small>
        </h1>

    </div>
@stop

@section('page_content')


    <div class="container defaultcontent">

        <div class="row">
            <div class="col-md-8 center-block">

                <div class="row">

                    <div class="col-md-12 content">

                        @if($post->hasType())
                            <div style="margin:-35px 0 15px;">
                                {!! $post->presentType() !!}
                            </div>
                        @endif

                        {{--<div class="summary markdown-content" itemprop="caption">--}}
                            {{--{!! Markdown::convertToHtml($post->summary()) !!}--}}
                        {{--</div>--}}

                        <div class="markdown-content" itemprop="articleBody">
                            {!! Markdown::convertToHtml($post->content()) !!}
                        </div>

                        <p>
                            <br/>
                            <a href="{{route('news.index')}}">&laquo; News overview</a>
                        </p>
                    </div>
                </div>

            </div>
        </div>
    </div>

@stop