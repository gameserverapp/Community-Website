@extends('layouts.v3.default', [
    'page' => [
        'title' => 'Edit about - ' . $character->name(),
        'description' => '',
        'class' => 'character-single about',
        //'bg' => $character->backgroundImage()
    ]
])

@section('page_content')

    @include('pages.v3.character._header')

    <form method="post" action="{{route('character.about.store', $character->id)}}" enctype="multipart/form-data">
        {{csrf_field()}}
        <div class="row">
            <div class="col-md-4">

                @component('partials.v3.frame', [
                    'title' => 'Image',
                    'footer' => '<small>Max. 500KB | Supported: png, jpg, jpeg, gif</small>'
                ])
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Image</label>
                                <p>
                                    Personalize your character about page with a selfie.
                                </p>

                                <input class="form-control" type="file" name="image">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="thumbnail">
                                @if($character->hasAboutImage())
                                    <img src="{{$character->aboutImageUrl()}}" style="max-width:200px; max-height:200px; height:auto; width:100%;">
                                @endif
                            </div>
                        </div>
                    </div>
                    <br>
                @endcomponent

            </div>
            <div class="col-md-8">

                @component('partials.v3.frame', [
                    'title' => 'About ' . $character->name()
                ])
                    <div class="form-group">
                        <textarea type="text" class="form-control simplemde" name="about">{{old('about', $character->about())}}</textarea>
                    </div>

                    <br>

                    @include('partials.v3.button', [
                        'element' => 'button',
                        'type' => 'submit',
                        'title' => 'Save',
                        'class' => 'center btn-theme-rock'
                    ])
                @endcomponent

            </div>
        </div>
    </form>


@stop