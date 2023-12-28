@extends('layouts.v3.default', [
    'page' => [
        'title' => 'Discord connected!',
        'description' => '',
        'class' => 'error pagebuilder'
    ],
])
@section('page_content')

    <div class="row padding-2">
        <div class="col-md-6 center-block">
            @component('partials.v3.frame', ['class' => 'text-center no-bottom-margin', 'title' => 'Your Discord is now connected'])

                <p>
                    Get ready for some bot magic!
                </p>

                <br>

                <img src="https://media.giphy.com/media/opmIBtljGbwZi/giphy.gif">

            @endcomponent
        </div>
    </div>

@endsection