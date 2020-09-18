@extends('layouts.v3.default', [
    'page' => [
        'title' => translate('messages', 'Messages'),
        'description' => 'Send a message to fellow players.',
        'class' => 'shop'
    ],

    'breadcrumbs' => [
        [
            'title' => auth()->user()->name(),
            'route' => route('user.settings', 'me')
        ],
        [
            'title' => translate('messages', 'Messages')
        ]
    ]
])

@section('page_content')

    <div class="row">

        <div class="col-md-12 text-center">
            <h1>{{translate('disabled_by_admin', 'Disabled by admin')}}</h1>
        </div>

    </div>

@stop