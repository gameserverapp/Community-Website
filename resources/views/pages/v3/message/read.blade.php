<?php
use GameserverApp\Helpers\SiteHelper;
use Illuminate\Support\Facades\Request;
?>

<?php
if(auth()->id() == $message->receiver->id) {
    $title = 'from ' . $message->sender->showLink();

    $breadcrumb = [
        'title' => translate('messages_inbox', 'Messages [Inbox]'),
        'route' => route('message.inbox')
    ];
} else {
    $title = 'to ' . $message->receiver->showLink();

    $breadcrumb = [
        'title' => translate('messages_outbox', 'Messages [Outbox]'),
        'route' => route('message.outbox')
    ];
}


?>

@extends('layouts.v3.default', [
    'page' => [
        'title' => translate('read_message', 'Read message'),
        'description' => 'Send a message to fellow players.',
        'class' => 'message read'
    ],

    'breadcrumbs' => [
        [
            'title' => auth()->user()->name(),
            'route' => route('user.settings', 'me')
        ],
        $breadcrumb,
        [
            'title' => $message->subject
        ]
    ]
])

@section('page_content')

    <div class="row">

        <div class="col-md-8 center-block text-center">
            <h1 class="main-title">
                <div>
                    {{$message->subject}}
                </div>

                <small class="label label-theme">
                    {!! ucfirst($title) !!}
                    -
                    {{$message->date('created_at')->diffForHumans()}}

                </small>
            </h1>
        </div>

    </div>
    <div class="row">
        <div class="col-md-8 center-block">

            @component('partials.v3.frame', ['type' => 'big'])
                {!! Markdown::convertToHtml($message->content()) !!}
            @endcomponent

            @if(auth()->id() != $message->sender->id)
                @if($message->receiver->canSendMessage())
                    @include('pages.v3.message._form', ['reply' => $message])
                @else
                    <div class="text-center">
                        <div class="alert alert-info">Replying to this message is disabled.</div>
                    </div>
                @endif
            @endif

        </div>
    </div>

@stop