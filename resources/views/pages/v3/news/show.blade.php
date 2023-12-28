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
            @foreach($item->category() as $label)
                <div class="label label-theme category">
                    {!! $label !!}
                </div>
            @endforeach

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
        @forelse($items as $subItem)
            <div class="col-md-4">
                @include('partials.v3.article-vertical', [
                    'title' => $subItem->title(),
                    'summary' => $subItem->summary(),
                    'category' => $subItem->category(),
                    'route' => $subItem->showRoute(),
                    'date' => $subItem->publishedAt(),
                    'image' => $subItem->image(),
                    'class' => 'article-small'
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

@endsection