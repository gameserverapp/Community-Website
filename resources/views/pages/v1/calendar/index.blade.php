@extends('layouts.v2.banner', [
    'page' => [
        'title' => 'Calendar',
        'description' => 'Find out what is happening and what is coming up!',
        'class' => 'calendar archive'
    ],
    'banner' => [
        'size' => 'large',
        'text-only' => false,
        'vertical-align' => true,
    ]
])

@section('banner_content')

    <div class="col-md-8  full-content-banner text-only banner-container center-block">
        <h1>
            Calendar
        </h1>

        <div class="row defaultcontent">
            <div class="calendar-js" style="height:1000px"></div>
        </div>
    </div>

@stop

@section('page_content')


@stop