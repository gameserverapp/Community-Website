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
                <img src="https://i.giphy.com/hkEQSFtxLrDI4.webp">
                <br><br><br>
                <h1>Something went wrong</h1>

                <p>
                    The web server experienced an issue while processing your request. Please try again in a couple seconds.
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