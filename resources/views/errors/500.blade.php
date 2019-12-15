@extends('layouts.v2.banner', [
    'page' => [
        'title' => 'Whoops',
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
    <i class="fa fa-bug"></i> A wild bug appeared
@stop

@section('page_content')

    <div class="container introtext">
        <div class="row">
            <div class="col-md-8 center-block text-center">
                <h2>
                    Ohh boy, seems like something went wrong.
                </h2>
                <p>
                    A report was send to the developers, to clean up their mess!
                </p>
                <img src="https://media3.giphy.com/media/3oKIPwoeGErMmaI43S/giphy.gif">
            </div>
        </div>
    </div>

    <div class="container-fluid defaultcontent">

        <div class="container ">
            <div class="row">
                <div class="col-md-4 center-block">
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