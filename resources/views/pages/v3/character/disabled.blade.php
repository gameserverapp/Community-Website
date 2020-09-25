@extends('layouts.v3.default', [
    'page' => [
        'title' => translate('character', 'Character'),
        'description' => '',
        'class' => ''
    ],

    'breadcrumbs' => [
        [
            'title' => translate('character', 'Character')
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