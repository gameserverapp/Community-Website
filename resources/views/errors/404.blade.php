@extends('layouts.v3.default', [
    'page' => [
        'title' => 'Page not found',
        'description' => '',
        'class' => 'error pagebuilder'
    ],
])
@section('page_content')

    <div class="row padding-2">
        <div class="col-md-6 center-block">
            @component('partials.v3.frame', ['class' => 'text-center no-bottom-margin'])
                <h1>Page not found</h1>

                <p>
                    Looks like this page no longer exists or is moved to a new location.
                </p>

                <br>
                <div class="row">
                    <div class="col-md-6 text-center">
                        <a class="btn btn-theme" href="{{url()->previous()}}"><span>Previous page</span></a>
                    </div>
                    <div class="col-md-6 text-center">
                        <a class="btn btn-theme btn-theme-rock" href="/"><span>Home</span></a>
                    </div>
                </div>
            @endcomponent
        </div>
    </div>

@endsection