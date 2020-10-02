@extends('layouts.v3.default', [
    'page' => [
        'title' => $user->name(),
        'description' => '',
        'class' => 'user-single'
    ]
])

@section('page_content')
    @include('pages.v3.user._header')

    <div class="row">

        <div class="col-md-12 text-center">
            <h1 class="main-title">{{translate('disabled_by_admin', 'Disabled by admin')}}</h1>
        </div>

    </div>
@stop