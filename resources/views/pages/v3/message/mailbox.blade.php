<?php
use GameserverApp\Helpers\SiteHelper;
use Illuminate\Support\Facades\Request;

if($title == 'Inbox') {
    $breadcrumb = [
        'title' => translate('messages_inbox', 'Messages [Inbox]'),
    ];
} else {
    $breadcrumb = [
        'title' => translate('messages_outbox', 'Messages [Outbox]'),
    ];
}
?>

@extends('layouts.v3.default', [
    'page' => [
        'title' => translate('messages', 'Messages'),
        'description' => 'Send a message to fellow players.',
        'class' => 'message'
    ],

    'breadcrumbs' => [
        [
            'title' => auth()->user()->name(),
            'route' => route('user.settings', 'me')
        ],
        $breadcrumb
    ]
])

@section('page_content')

    <div class="row">

        <div class="col-md-4">

        </div>
        <div class="col-md-4 text-center">
            <h1>{{$title}}</h1>
        </div>

        <div class="col-md-4 text-right">


            @if($title == 'Inbox')
                @include('partials.v3.button', [
                    'route' => route('message.outbox'),
                    'title' => translate('outbox', 'Outbox'),
                ])
            @else
                @include('partials.v3.button', [
                    'route' => route('message.inbox'),
                    'title' => translate('inbox', 'Inbox'),
                ])
            @endif
        </div>

    </div>
    <div class="row">
        <div class="col-md-9">

            @component('partials.v3.frame')

                @forelse($messages as $message)

                    <div class="message-item @if( !$message->read() and $message->receiver->id == auth()->id() ) new @endif">
                        <div class="row">

                            <div class="col-xs-6 col-sm-2 sender">
                                @if( $message->sender->id == auth()->id() )
                                    {!! $message->receiver->showLink() !!}
                                @else
                                    {!! $message->sender->showLink() !!}
                                @endif
                            </div>

                            <a href="{{$message->showRoute()}}" class="messagelink">

                                <div class="col-xs-6 col-sm-2 pull-right date">
                                    <time date="{{$message->date('created_at')->toDateTimeString()}}"
                                          title="{{$message->date('created_at')->toDayDateTimeString()}}">
                                        {{$message->date('created_at')->diffForHumans()}}
                                    </time>
                                </div>

                                <div class="col-xs-12 col-sm-8 subject">

                                    @if( !$message->read() and $message->receiver->id == auth()->id() )
                                        <span class="label label-theme">NEW</span>
                                        <strong>{{$message->subject()}}</strong>
                                    @else
                                        {{$message->subject()}}
                                    @endif

                                    <span class="summary">
                                        -
                                        {{str_limit( $message->content(), 60)}}
                                    </span>
                                </div>
                            </a>

                        </div>
                    </div>
                @empty
                    <div class="message-item text-center">
                        <em>No messages...</em>
                    </div>
                @endforelse

            @endcomponent


            <div class="paginate">
                {!! $messages->links() !!}
            </div>

        </div>

        <div class="col-md-3 text-right">

            @if($contacts and auth()->user()->canSendMessage())
                @include('pages.v3.message._new-button')
            @endif

        </div>
    </div>

@stop