@extends('layouts.v2.bannerless', [
    'page' => [
        'title' => 'Failed connecting',
        'description' => '',
        'class' => 'discord '
    ]
])
@section('page_content')

    <div class="container defaultcontent read">
        <div class="row">
            <div class="col-md-6 center-block">
                @include('partials.frame.simple-top')
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            Failed connecting
                        </h3>
                    </div>

                    <div class="panel-body">
                        <img src="https://media.giphy.com/media/EizPK3InQbrNK/giphy.gif">
                    </div>
                </div>
                @include('partials.frame.simple-bottom')
            </div>
        </div>
    </div>

@stop