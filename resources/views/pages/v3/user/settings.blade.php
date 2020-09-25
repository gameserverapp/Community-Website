@extends('layouts.v3.default', [
    'page' => [
        'title' => translate('your_settings', 'Your settings'),
        'description' => 'Manage your settings',
        'class' => 'article-index'
    ],

    'breadcrumbs' => [
        [
            'title' => auth()->user()->name(),
            'route' => route('user.settings', 'me')
        ],
        [
            'title' => translate('your_settings', 'Your settings')
        ]
    ]
])

@section('page_content')
    <div class="row">
        <div class="col-md-12 text-center">
            <h1 class="main-title">{{translate('your_settings', 'Your settings')}}</h1>
        </div>
    </div>

    <div class="row">

        <div class="col-md-8">
            <form method="post" action="{{route('user.settings.store', auth()->id())}}">

                @component('partials.v3.frame', ['title' => 'Notifications'])
                    <strong>
                        Your email address
                    </strong>
                    <p>
                        On which email address would you like to be notified?
                    </p>
                    {!! Form::email('email', old('email', auth()->user()->notifications['email']), array('class' => 'form-control', 'placeholder'=>'Your email address')) !!}

                    <br>
                    @if(auth()->user()->hasEmailSetup() and !auth()->user()->emailConfirmed())
                        <div class="alert alert-warning">
                            <strong>Please confirm your email address by clicking the link in the confirmation email.</strong> <a href="{{route('user.confirm_email.resend', $user->id)}}">Resend confirmation</a>
                        </div>
                        <br>
                    @endif
                    <div class="alert alert-info">
                        <strong>We hate spam, just like you!</strong>
                        Your email address is stored in the GameServerApp.com database and will only be used for alerts, which you can choose below. Your email address will <u>not</u> be sold to 3rd parties.
                    </div>

                    <hr>

                    <strong>
                        When a player sends you a message
                    </strong>
                    <p class="small">
                        Only active players can send a message to you.
                    </p>
                    <div class="row">
                        <div class="col-md-3">
                            <label>
                                {!! Form::checkbox('notify_message', 1, old('notify_message', auth()->user()->notifications['notify_message'])) !!}
                                Notify via email
                            </label>
                        </div>

                    </div>

                    <hr>

                    <strong>
                        When an alert is triggered
                    </strong>
                    <p class="small">
                        Receive a notification when an in-game webalert is triggered.<br>Webalerts involve: tripwire activation or a baby hatching.
                    </p>
                    <div class="row">
                        <div class="col-md-3">
                            <label>
                                {!! Form::checkbox('notify_webalert', 1, old('notify_webalert', auth()->user()->notifications['notify_webalert'])) !!}
                                Notify via email
                            </label>
                        </div>

                    </div>


                    <hr>

                    <strong>
                        Reply on subscribed forum thread
                    </strong>
                    <p class="small">
                        When somebody replies to a thread or post you are subscribed to.
                    </p>
                    <div class="row">
                        <div class="col-md-3">
                            <label>
                                {!! Form::checkbox('notify_forum', 1, old('notify_forum', auth()->user()->notifications['notify_forum'])) !!}
                                Notify via email
                            </label>
                        </div>

                    </div>

                    <br>
                    @include('partials.v3.button', [
                        'type' => 'submit',
                        'element' => 'button',
                        'title' => translate('save_settings', 'Save settings'),
                        'class' => 'center'
                    ])
                @endcomponent

            </form>
        </div>

        <div class="col-md-4">

            @include('pages.v3.user._discord')

            @include('pages.v3.user._twitch')

            @include('pages.v3.user._kick')

        </div>

    </div>



@stop