@extends('layouts.v3.default', [
    'page' => [
        'title' => translate('inspector', 'Inspector'),
        'description' => 'Search all characters and groups on the community.',
        'class' => 'inspector'
    ],

    'breadcrumbs' => [
        [
            'title' => translate('inspector', 'Inspector')
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