@extends('layouts.v3.default', [
    'page' => [
        'title' => $user->name(),
        'description' => '',
        'class' => 'user-index'
    ],

    'breadcrumbs' => [
        [
            'title' => $user->name
        ]
    ]
])

@section('page_content')
    <div class="row">
        <div class="col-md-12 text-center">
            <h1 class="main-title">{{translate('your_settings', 'Your settings')}}</h1>
        </div>
    </div>

@stop