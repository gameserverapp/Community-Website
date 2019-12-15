@extends('layouts.v2.banner', [
    'page' => [
        'title' => 'Page not found',
        'description' => '',
        'class' => 'page404'
    ],
    'banner' => [
        'size' => 'small',
        'animated' => true,
        'text-only' => true,
        'vertical-align' => true
    ]
])


@section('banner_content')
    <i class="fa fa-bicycle"></i> Whoopsie
@stop

@section('page_content')

    <div class="container introtext">
        <div class="row">
            <div class="col-md-8 center-block text-center">
                <h2>
                    Looks like this page no longer exists or is moved to a new location.
                </h2>
            </div>
        </div>
    </div>

    <div class="container-fluid defaultcontent">

        <div class="container ">
            <div class="row">
                <div class="col-md-6 center-block">
                    <p>
                        There are a couple of things you can do:
                    </p>

                    <ul>
                        <li>
                            Go <a href="{{url()->previous()}}">back to where you came from</a>
                        </li>
                        <li>
                            Go to the <a href="/">homepage</a> and start over.
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

@stop