@extends('layouts.v3.default', [
    'page' => [
        'title' => translate('token_transactions', 'Token transactions'),
        'description' => '',
        'class' => ''
    ],

    'breadcrumbs' => [
        [
            'title' => auth()->user()->name(),
            'route' => route('user.settings', 'me')
        ],
        [
            'title' => translate('token_transactions', 'Token transactions')
        ]
    ]
])

@section('page_content')

    <div class="row">

        <div class="col-md-12 text-center">
            <h1 class="main-title">{{translate('disabled_by_admin', 'Disabled by admin')}}</h1>
        </div>

    </div>

@stop