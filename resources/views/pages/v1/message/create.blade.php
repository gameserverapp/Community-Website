@extends('layouts.v2.banner', [
    'page' => [
        'title' => 'Send message',
        'description' => '',
        'class' => 'message account create'
    ],
    'banner' => [
        'size' => 'small',
        'text-only' => true,
        'vertical-align' => true,
        'navigation' => 'pages.v1.message.partials.navigation',
    ]
])


@section('banner_content')
    New message to
    {!! $receiver->showName() !!}
@stop


@section('page_content')

    <div class="container defaultcontent">
        <div class="row">
            <div class="col-md-10 center-block">
                @include('pages.v1.message.partials.form')
            </div>
        </div>
    </div>

@stop