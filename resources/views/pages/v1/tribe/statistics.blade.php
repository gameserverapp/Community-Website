@extends('layouts.v2.banner', [
    'page' => [
        'title' => 'Statistics - ' . $tribe->name(),
        'description' => '',
        'class' => 'tribe log'
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

    <div class="container defaultcontent">
        <div class="row">

            @forelse( $stats as $name => $stat )

                @if( $stat )
                    <div class="col-md-10 center-block">

                        @include('partials.frame.simple-top')
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">
                                    {{$name}}
                                </h3>
                            </div>

                            <div class="panel-body">

                                @if(isset($stat['data']) and isset($stat['options']))
                                    <div class="stat_canvas"
                                         data-data='{!! json_encode($stat['data']) !!}'
                                         data-options='{!!json_encode($stat['options'])!!}'></div>
                                @endif
                            </div>
                        </div>
                        @include('partials.frame.simple-bottom')
                    </div>
                @endif

            @empty
                @include('partials.frame.simple-top')
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            No statistics yet
                        </h3>
                    </div>

                    <div class="panel-body">
                        Looks like there is to little data for this account
                    </div>
                </div>
                @include('partials.frame.simple-bottom')
            @endforelse

        </div>

        {{--<div class="row">--}}
            {{--<div class="col-md-10 center-block">--}}
                {{--<div class="alert alert-info">--}}
                    {{--<span>--}}
                        {{--Some stats aren't properly functioning. This will be fixed soon :)--}}
                    {{--</span>--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}
    </div>

@stop