@extends('layouts.v3.default', [
    'page' => [
        'title' => 'About - ' . $character->name(),
        'description' => '',
        'class' => 'character-single about',
        //'bg' => $character->backgroundImage()
    ]
])

@section('page_content')
    @include('pages.v3.character._header')

    <div class="row">
        <div class="col-md-4">

            @if($character->hasAboutImage())
                <div class="image">
                    <img src="{{$character->aboutImageUrl()}}">
                </div>
            @else
                @component('partials.v3.frame', [
                    'type' => 'basic',
                    'class' => 'text-center'
                ])
                    <em>{{$character->name()}} has no image yet.</em>
                @endcomponent
            @endif

        </div>
        <div class="col-md-8">

            @component('partials.v3.frame', [
                'title' => 'About ' . $character->name()
            ])
                @if($character->hasAbout())
                    {!! Markdown::convertToHtml($character->about()) !!}
                @else
                    <em>{{$character->name()}} has no about information yet.</em>
                @endif

                @if(
                    auth()->check() and
                    auth()->id() == $character->user->id
                )
                    <br><br>
                    <div class="edit">
                        <a class="btn btn-theme small" href="{{route('character.about.edit', $character->id)}}"><span>Edit</span></a>
                    </div>
                @endif
            @endcomponent

        </div>
    </div>


@stop