@extends('layouts.v2.banner', [
    'page' => [
        'title' => $tribe->name,
        'description' => '',
        'class' => 'tribe dashboard'
    ],
    'banner' => [
        'size' => 'small',
        'animated' => true,
        'text-only' => true,
        'vertical-align' => true,
        'navigation' => 'pages.v1.tribe.partials.navigation',
        'background' => [
            'tribe' => $tribe->bannerBackground()
        ]
    ]
])

@section('banner_content')
    @include('pages.v1.tribe.partials.banner')
@stop

@section('page_content')

    <div class="container introtext text-center">
        <div class="row">

            <h2>
                <i class="fa fa-lock"></i>
                You need to be part of "{{$tribe->name}}" to access this page
            </h2>

        </div>
    </div>

@stop