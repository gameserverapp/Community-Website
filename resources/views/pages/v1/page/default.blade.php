@extends('layouts.v2.banner', [
    'page' => [
        'title' => $title,
        'description' => $meta['description'],
        'class' => $settings['class']
    ],
    'banner' => $settings['banner']
])

@section('banner_content')
    @if($settings['icon'])
        <i class="{{$settings['icon']}}"></i>
    @endif
    {{$title}}
@stop

@section('page_content')

    <div class="container defaultcontent">
        <div class="row">
            <div class="col-sm-10 center-block">
                {!! $content !!}
            </div>
        </div>
    </div>

@stop