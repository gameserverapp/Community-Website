@extends('layouts.v3.default', [
    'page' => [
        'title' => $character->name(),
        'description' => '',
        'class' => 'character-single',
        //'bg' => $character->backgroundImage()
    ]
])

@section('page_content')
    @include('pages.v3.character._header')

    <div class="row">
        <div class="col-md-8">


        </div>
        <div class="col-md-4">


        </div>
    </div>
@stop