@extends('layouts.v2.banner', [
    'page' => [
        'title' => 'Shop disabled',
        'description' => '',
        'class' => 'message account'
    ],
    'banner' => [
        'size' => 'small',
        'animated' => true,
        'text-only' => false,
        'vertical-align' => true,
    ]
])


@section('banner_content')
    <div class="col-md-8 text-only center-block">
        <h1>
            Feature disabled by admin
        </h1>
    </div>
@stop

@section('page_content')

    <div class="container defaultcontent">

        <div class="row">

            <div class="col-md-12 text-center">

                <h3>Nothing to see here</h3>

            </div>

        </div>
    </div>

@stop