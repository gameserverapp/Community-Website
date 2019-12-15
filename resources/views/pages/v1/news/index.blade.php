@extends('layouts.v2.banner', [
    'page' => [
        'title' => 'Latest news',
        'description' => 'Find out what is happening and what is coming up!',
        'class' => 'news archive'
    ],
    'banner' => [
        'size' => 'small',
        'down-button' => true,
        'animated' => true,
        'text-only' => true,
        'vertical-align' => true
    ]
])

@section('banner_content')

    <i class="fa fa-newspaper-o"></i> News & updates

@stop

@section('page_content')

    <div class="container defaultcontent">

        <div class="row">
            <div class="col-md-8 center-block">

                @forelse( $posts as $post )
                    @include('pages.v1.partials.article-block')
                @empty
                    <em>
                        No news found
                    </em>
                @endforelse

                <div class="paginate">
                    {!! $posts->links() !!}
                </div>

            </div>
        </div>
    </div>

@stop