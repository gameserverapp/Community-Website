@extends('layouts.v3.default', [
    'page' => [
        'title' => translate('group', 'Group'),
        'description' => '',
        'class' => ''
    ],

    'breadcrumbs' => [
        [
            'title' => translate('group', 'Group')
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