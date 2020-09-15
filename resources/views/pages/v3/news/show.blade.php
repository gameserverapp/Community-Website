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

    'breadcrumbs' => [
        [
            'title' => translate('news', 'News'),
            'route' => route('news.index')
        ],
        [
            'title' => $item->title()
        ],
    ]
])

@section('page_content')

    @component('partials.v3.frame', [
        'banner' => [
            'title' => $item->title(),
            //'category' => $item->category(),
            //'date' => $item->publishedAt(),
            'image' => $item->image()
        ]
    ])
        <div class="meta">
            @if($item->hasType())
                <div class="label label-theme category">{!! $item->category() !!}</div>
            @endif

            <time class=" date" datetime="{{$item->publishedAt()->toDateTimeString()}}" itemprop="datePublished">
                {{$item->publishedAt()->format('j F Y')}}
            </time>
        </div>

        <div class="content">
            {!! $item->content() !!}
        </div>
    @endcomponent


    @include('partials.v3.hr-title', [
        'title' => translate('more_news', 'More news')
    ])

    <div class="row">
        @forelse($items as $item)
            <div class="col-md-4">
                @include('partials.v3.article-vertical', [
                    'title' => $item->title(),
                    'summary' => $item->summary(),
                    'category' => $item->category(),
                    'route' => $item->showRoute(),
                    'date' => $item->publishedAt(),
                    'image' => $item->image()
                ])
            </div>
        @empty
            <div class="col-md-12 text-center">
                <p>
                    <em>
                        No news found
                    </em>
                </p>
            </div>
        @endforelse
    </div>

@stop