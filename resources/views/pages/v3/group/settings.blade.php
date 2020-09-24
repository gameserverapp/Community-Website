@extends('layouts.v3.default', [
    'page' => [
        'title' => 'Settings - ' . $group->name(),
        'description' => str_limit($group->about(), 200),
        'class' => 'group-single',
        'bg' => $group->backgroundImage()
    ]
])

@section('page_content')
    @include('pages.v3.group._header')

    <div class="row">
        <div class="col-md-4">

            <div class="row">
                <div class="col-md-12">
                    @include('pages.v3.group._logo')
                </div>
                <div class="col-md-12">
                    @include('pages.v3.group._visual')
                </div>
            </div>

        </div>
        <div class="col-md-4">
            @include('pages.v3.group._settings')
        </div>
        <div class="col-md-4">
            @include('pages.v3.group._discord')
        </div>
    </div>
@stop