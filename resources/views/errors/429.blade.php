@extends('layouts.v3.default', [
    'page' => [
        'title' => 'Calm down!',
        'description' => '',
        'class' => 'error pagebuilder'
    ],
])

@section('page_content')

    <div class="row padding-2">
        <div class="col-md-6 center-block">
            @component('partials.v3.frame', ['class' => 'text-center no-bottom-margin'])
                <img src="https://media2.giphy.com/media/UJS4fUKBaTc8o/giphy.gif">
                <br><br><br>
                <h1>Too many requests</h1>

                <p>
                    The web server is receiving too many requests. Please try again later.
                </p>

                <br>
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