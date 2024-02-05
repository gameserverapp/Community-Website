<?php
use GameserverApp\Helpers\SiteHelper;
use Illuminate\Support\Facades\Request;
$user = auth()->user();
$user = auth()->user();

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
        'class' => 'message user-single'
    ],
])

@section('page_content')

    @include('pages.v3.user._header')
    <div class="row">
        <div class="col-md-9">

            @component('partials.v3.frame', ['class' => 'tiny-padding'])

                @forelse($messages as $message)

                    <div class="message-item @if( !$message->read() and in_array($message->receiver->id, auth()->user()->subUserIds()) ) new @endif">
                        <div class="row">

                            <div class="col-xs-6 col-sm-2 sender">
                                @if( in_array($message->sender->id, auth()->user()->subUserIds()) )
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

                                    @if( !$message->read() and in_array($message->receiver->id, auth()->user()->subUserIds()) )
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
                @include('pages.v3.user.message._new-button')
            @endif

        </div>
    </div>

@endsection