<?php
use GameserverApp\Helpers\PremiumHostedHelper;
?>

@extends('layouts.v3.default', [
    'page' => [
        'title' => 'Failed connecting',
        'description' => '',
        'class' => 'error pagebuilder'
    ],
])

@section('page_content')

    <div class="row padding-2">
        <div class="col-md-6 center-block">
            @component('partials.v3.frame', ['class' => 'text-center no-bottom-margin', 'title' => 'Failed to connect Discord'])
                <p>
                    Something happened while connecting your Discord account.<br>
                    Try again or reach out to the admin.
                </p>

                <br>

                <img src="https://media.giphy.com/media/EizPK3InQbrNK/giphy.gif">

                <br><br>
                <div class="row">
                    <div class="col-md-12 text-center">
                        <a class="btn btn-theme btn-theme-rock" href="{{config('gameserverapp.connection.oauth_base_url')}}frontend/oauth/discord/user?client_id={{PremiumHostedHelper::clientId()}}"><span>Try again</span></a>
                    </div>
                </div>
            @endcomponent
        </div>
    </div>

@endsection