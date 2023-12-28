@extends('layouts.v2.banner', [
    'page' => [
        'title' => 'Feature disabled',
        'description' => '',
        'class' => 'tribe dashboard'
    ],
    'banner' => [
        'size' => 'small',
        'animated' => true,
        'text-only' => true,
        'vertical-align' => true
    ]
])

@section('banner_content')
    <div class="col-md-8 text-only center-block">
        <h1>
            Feature disabled by admin
        </h1>
    </div>
@endsection

@section('page_content')
    <div class="container defaultcontent">

        <div class="row">

            <div class="col-md-12 text-center">

                <h3>Nothing to see here</h3>

            </div>

        </div>
    </div>
@endsection