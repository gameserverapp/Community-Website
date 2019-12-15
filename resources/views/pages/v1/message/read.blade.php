@extends('layouts.v2.banner', [
    'page' => [
        'title' => 'Inbox',
        'description' => '',
        'class' => 'message read account'
    ],
    'banner' => [
        'size' => 'small',
        'vertical-align' => true,
        'navigation' => 'pages.v1.message.partials.navigation',
    ]
])


@section('banner_content')
    <div class="col-md-8 text-only center-block">
        <h1>
            {{$message->subject}}
            <small>
                @if(auth()->id() == $message->receiver->id)
                    from
                    {!! $message->sender->showLink() !!}
                @else
                    to
                    {!! $message->receiver->showLink() !!}
                @endif
                -
                {{$message->date('created_at')->diffForHumans()}}

            </small>
        </h1>
    </div>
@stop

@section('page_content')

    <div class="container defaultcontent read">
        <div class="row">
            <div class="col-md-10 center-block">

                @include('partials.frame.simple-top')
                <div class="well markdown-content">
                    {!! Markdown::convertToHtml($message->content()) !!}
                </div>
                @include('partials.frame.simple-bottom')

                {{--@if( auth()->user()->id != $receiver->id )--}}
                    {{--<div class="text-right tools">--}}
                        {{--<a href="mailto:website-support@championark.com" class="report">--}}
                            {{--<i class="fa fa-ban"></i>--}}
                            {{--Report a problem--}}
                        {{--</a>--}}
                    {{--</div>--}}
                {{--@endif--}}

            </div>
        </div>
    </div>


    @if(auth()->id() != $message->sender->id and !$message->receiver->banned())
        <div class="container defaultcontent" id="reply">
            <div class="row">
                <div class="col-md-10 center-block">
                    @include('pages.v1.message.partials.form', ['reply' => $message])
                </div>
            </div>
        </div>
    @endif

@stop