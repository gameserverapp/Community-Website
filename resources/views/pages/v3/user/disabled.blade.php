@extends('layouts.v3.default', [
    'page' => [
        'title' => 'Disabled by admin',
        'description' => '',
        'class' => 'user-single'
    ]
])

@section('page_content')

    <div class="row">

        <div class="col-md-12 text-center">
            <h1 class="main-title">{{translate('disabled_by_admin', 'Disabled by admin')}}</h1>
        </div>

    </div>
@endsection