@extends('layouts.v3.default', [
    'page' => [
        'title' => 'Whoops',
        'description' => '',
        'class' => 'error pagebuilder'
    ],
])

@section('page_content')

    <div class="row padding-2">
        <div class="col-md-6 center-block">
            @component('partials.v3.frame', ['class' => 'text-center no-bottom-margin'])
                <img src="https://media3.giphy.com/media/3oKIPwoeGErMmaI43S/giphy.gif">
                <br><br><br>
                <h1>A wild bug appeared!</h1>

                <p>
                    Ohh boy, seems like something went wrong.<br>
                    A report was send to the developers, to check it out!
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
@stop