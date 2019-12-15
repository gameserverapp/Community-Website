@extends('layouts.v2.banner', [
    'page' => [
        'title' => 'Join ' . GameserverApp\Helpers\SiteHelper::name(),//'Access restricted',
        'description' => '',
        'class' => 'login restricted'
    ],
    'banner' => [
        'size' => 'small',
        'down-button' => false,
        'animated' => true,
        'text-only' => true,
        'vertical-align' => true
    ]
])


@section('banner_content')
    <i class="fa fa-child"></i>Join {{GameserverApp\Helpers\SiteHelper::name()}}
@stop

@section('page_content')


    <div class="container introtext">
        <div class="row">
            <div class="col-md-6 center-block  text-center">

                <div class="well">
                    <h2>
                        {{-- This content is only visible for members. Please log in! --}}
                        Log in with STEAM
                    </h2>
                    <p>
                        To view this page, you need to login.
                    </p>
                    <br/>
                    <p>
                        <a href="{{route('auth.login')}}" class="btn btn-default champ">
                            <i class="fa fa-lock"></i> Secure login with <strong>STEAM</strong>
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>


    {{--
        <div class="container-fluid fulldark">
            <div class="container">
                <div class="row">
                    <div class="col-md-7 center-block text-center">
                        <h2>
                            New to Champion ARK?
                        </h2>
                        <p>
                            Don't worry, you can log in using your STEAM account. This is quick and safe!<br/>Even when you
                            haven't played on one of our servers yet!
                        </p>
                        <p>
                            More information <a href="{{route('page.steam')}}">about STEAM login</a>.
                        </p>
                        <p>
                            <small>
                                PS: Welcome to Champion, enjoy! :)
                            </small>
                        </p>
                    </div>
                </div>
            </div>
        </div>
     --}}
@stop

