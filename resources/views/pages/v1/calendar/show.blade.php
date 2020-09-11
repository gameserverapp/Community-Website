<?php
$banner = [
    'size' => 'small',
    'vertical-align' => true
];

if($calendar->hasImage()) {
    $banner['background']['img'] = $calendar->image();
    $banner['class'] = 'custom_bg';
}
?>

@extends('layouts.v2.banner', [
    'page' => [
        'title' => $calendar->title(),
        'description' => $calendar->metaDescription(),
        'class' => 'calendar news show',
        'attributes' => ''
    ],
    'microdata' => [
        'content' => 'itemscope itemtype="http://schema.org/Article"'
    ],
    'banner' => $banner
])

@section('banner_content')
    <div class="col-md-8 text-only center-block">

        <h1>
            <span itemprop="headline">{!! $calendar->title() !!}</span>
            <br>
            <small>
                <time itemprop="datePublished" datetime="{{$calendar->date('start_at')->toDateTimeString()}}">{{$calendar->date('start_at')->format('j F Y')}}</time>
            </small>
        </h1>

    </div>
@stop

@section('page_content')


    <div class="container defaultcontent">

        <div class="row">
            <div class="col-md-8 center-block">

                <div class="row">

                    <div class="col-md-12 content">

                        <div class="markdown-content" itemprop="articleBody">
                            {!! $calendar->description() !!}
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <h4>Details</h4>
                                <p>
                                    <strong>Starts at</strong>: <span class="local-time" data-time="{{$calendar->start_at}}"></span><br>

                                    <strong>Ends at</strong>: <span class="local-time" data-time="{{$calendar->end_at}}"></span>
                                </p>
                            </div>
                            <div class="col-md-6">
                                <h4>
                                    @if($calendar->participants > 0)
                                        Join {{$calendar->participants}} others at "{{$calendar->title()}}"
                                    @else
                                        Join "{{$calendar->title()}}"
                                    @endif
                                </h4>

                                <form method="post" action="{{route('calendar.participate', $calendar->id)}}">
                                    {{csrf_field()}}

                                    @if($calendar->participate)
                                        <button type="submit" class="btn btn-theme disabled"><span><i class="fa fa-check" aria-hidden="true"></i> Participating</span></button>
                                    @else
                                        <button type="submit" class="btn btn-theme"><span>Participate</span></button>
                                    @endif
                                </form>
                            </div>
                        </div>


                        @if($calendar->hasRelated())
                            <p>
                                {{$calendar->displayRelated()}}
                            </p>
                        @endif

                        <p>
                            <br/>
                            <a href="{{route('calendar.index')}}">&laquo; Calendar overview</a>
                        </p>
                    </div>
                </div>

            </div>
        </div>
    </div>

@stop