@extends('layouts.v3.default', [
    'page' => [
        'title' => 'Latest news',
        'description' => 'Find out what is happening and what is coming up!',
        'class' => 'article-index'
    ]
])

@section('page_content')


    @include('partials.v3.article-horizontal', [
        'title' => 'sdf saf sd fsd fadsf sdf adsf asdf',
        'summary' => 'sdf saf sd fsd fadsf sdf adsf asdf dsfsdf saf sd fsd fadsf sdf adsf asdf dsfsdf saf sd fsd fadsf sdf adsf asdf dsfsdf saf sd fsd fadsf sdf adsf asdf dsf ',
        'route' => '#',
        'date' => \Carbon\Carbon::now(),
        'image' => 'https://gamepedia.cursecdn.com/arksurvivalevolved_gamepedia/thumb/5/53/Genesis_27.jpg/1920px-Genesis_27.jpg'
    ])

    @forelse( $items->chunk(2) as $chunk )
        <div class="row">
            @foreach($chunk as $item)
                <div class="col-md-6">
                    @include('partials.v3.article-vertical', [
                        'title' => $item->title(),
                        'summary' => $item->summary(),
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

    <div class="paginate">
        {!! $items->links() !!}
    </div>

@stop