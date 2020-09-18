<?php
use GameserverApp\Helpers\SiteHelper;
use Illuminate\Support\Facades\Request;
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
        [
            'title' => translate('messages', 'Messages'),
            'route' => route('message.index')
        ],
        [
            'title' => 'New message'
        ]
    ]
])

@section('page_content')

    <div class="row">

        <div class="col-md-8 center-block text-center">
            <h1>
                New message
            </h1>
        </div>

    </div>
    <div class="row">
        <div class="col-md-8 center-block">

            @include('pages.v3.message._form')

        </div>
    </div>

@stop