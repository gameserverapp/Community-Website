@extends('layouts.v3.default', [
    'page' => [
        'title' => 'Latest news',
        'description' => 'Find out what is happening and what is coming up!',
        'class' => 'article-index'
    ],

    'breadcrumbs' => [
        [
            'title' => translate('news', 'News')
        ]
    ]
])

@section('page_content')

    @if($hero)
        @include('partials.v3.article-horizontal', [
            'title' => $hero->title(),
            'summary' => $hero->summary(),
            'category' => $hero->category(),
            'route' => $hero->showRoute(),
            'date' => $hero->publishedAt(),
            'image' => $hero->image()
        ])
    @endif

    @forelse( $latest->chunk(2) as $chunk )
        <div class="row">
            @foreach($chunk as $item)
                <div class="col-md-6">
                    @include('partials.v3.article-vertical', [
                        'title' => $item->title(),
                        'summary' => $item->summary(),
                        'category' => $item->category(),
                        'route' => $item->showRoute(),
                        'date' => $item->publishedAt(),
                        'image' => $item->image()
                    ])
                </div>
            @endforeach
        </div>
    @empty
        <em>
            No news found
        </em>
    @endforelse

    @include('partials.v3.hr-title', [
        'title' => translate('archive', 'Archive'),
        'id' => 'archive'
    ])

    @forelse( $items->chunk(3) as $chunk )
        <div class="row">
            @foreach($chunk as $item)
                <div class="col-md-4">
                    @include('partials.v3.article-vertical', [
                        'title' => $item->title(),
                        'summary' => $item->summary(),
                        'category' => $item->category(),
                        'route' => $item->showRoute(),
                        'date' => $item->publishedAt(),
                        'image' => $item->image(),
                        'class' => 'article-small'
                    ])
                </div>
            @endforeach
        </div>
    @empty
        <em>
            No news found
        </em>
    @endforelse

    <div class="paginate">
        {!! $items->fragment('archive')->links() !!}
    </div>

@stop