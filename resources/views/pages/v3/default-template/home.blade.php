@extends('layouts.v3.default', [
    'page' => [
        'title' => translate('home', 'Home'),
        'description' => '',
        'class' => 'home pagebuilder'
    ],
])

@section('page_content')

    <div class="row padding-2">
        <div class="col-md-4">
            @include('pagebuilder.v1.blocks.panels_top_5_characters')
        </div>
        <div class="col-md-4">
            @include('pagebuilder.v1.blocks.panels_last_5_fresh_survivors')
        </div>
        <div class="col-md-4">
            @include('pagebuilder.v1.blocks.panels_whos_online')
        </div>
    </div>

    <div class="row padding-2">
        <div class="col-md-6">
            @include('pagebuilder.v1.blocks.latest_forum_activity')
        </div>
        <div class="col-md-6">
            @include('pagebuilder.v1.blocks.latest_news_updates')
        </div>
    </div>

    <div class="row padding-2">
        <div class="col-md-12">
            @include('pagebuilder.v1.blocks.server_slider')
        </div>
    </div>

    <div class="row padding-2">
        <div class="col-md-12">
            @include('pagebuilder.v1.blocks.population_overview')
        </div>
    </div>

    <div class="row padding-2">
        <div class="col-md-12">
            @include('pagebuilder.v1.blocks.spotlight')
        </div>
    </div>
@stop