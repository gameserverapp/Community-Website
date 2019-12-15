@extends('layouts.v2.banner', [
    'page' => [
        'title' => 'Outbox',
        'description' => '',
        'class' => 'message account'
    ],
    'banner' => [
        'size' => 'small',
        'animated' => true,
        'text-only' => true,
        'vertical-align' => true,
        'navigation' => 'pages.v1.message.partials.navigation',
    ]
])


@section('banner_content')
    Outbox
@stop

@section('page_content')

    <div class="container defaultcontent read">
        @include('pages.v1.message.partials.list')
    </div>

@stop