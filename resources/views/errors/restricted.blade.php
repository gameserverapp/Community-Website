@extends('layouts.v3.default', [
    'page' => [
        'title' => 'Join ' . GameserverApp\Helpers\SiteHelper::name(),
        'description' => '',
        'class' => 'error pagebuilder'
    ],
])

@section('banner_content')
@endsection

@section('page_content')


    <div class="row padding-2">
        <div class="col-md-6 center-block">
            @component('partials.v3.frame', ['class' => 'text-center no-bottom-margin', 'type' => 'big'])
                <h1>
                    <i class="fa fa-child"></i>
                    Join {{GameserverApp\Helpers\SiteHelper::name()}}
                </h1>

                <p>
                    <strong>To view this page, you need to log in.</strong>
                    <br><br>
                    You can log in using your Steam, Epic, Minecraft, Discord, Twitch, Patreon, Microsoft and Google account. This is quick and secure.<br/>
                    Even when you haven't played on one of our servers yet.
                </p>

                <br>
                <div class="row">
                    <div class="col-md-12 text-center">
                        <a class="btn btn-theme btn-theme-rock" href="{{route('auth.login')}}">
                            <span>Login</span>
                        </a>
                    </div>
                </div>
            @endcomponent
        </div>
    </div>
@endsection

