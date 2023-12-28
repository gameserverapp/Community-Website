@extends('layouts.v3.default', [
    'page' => [
        'title' => translate('your_settings', 'Your settings'),
        'description' => 'Manage your settings',
        'class' => 'user-single'
    ],
])

@section('page_content')
    @include('pages.v3.user._header')

    <div class="row">

        <div class="col-md-6">
            <form method="post" action="{{route('user.settings.store', auth()->id())}}">
                {{csrf_field()}}

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
                        <strong>We hate spam, just like you!</strong><br>
                        Your email address is stored in the GameServerApp.com database and is only used for alerts below. Your email address <u>won't</u> be sold to 3rd parties.
                    </div>

                    <hr>

                    <strong>
                        When a player sends you a message
                    </strong>
                    <p class="small">
                        Only active players can send a message to you.
                    </p>
                    <label>
                        {!! Form::checkbox('notify_message', 1, old('notify_message', auth()->user()->notifications['notify_message'])) !!}
                        Notify via email
                    </label>

                    <hr>

                    <strong>
                        When an alert is triggered
                    </strong>
                    <p class="small">
                        Receive a notification when an in-game webalert is triggered.<br>Webalerts involve: tripwire activation or a baby hatching.
                    </p>
                    <label>
                        {!! Form::checkbox('notify_webalert', 1, old('notify_webalert', auth()->user()->notifications['notify_webalert'])) !!}
                        Notify via email
                    </label>


                    <hr>

                    <strong>
                        Reply on subscribed forum thread
                    </strong>
                    <p class="small">
                        When somebody replies to a thread or post you are subscribed to.
                    </p>
                    <label>
                        {!! Form::checkbox('notify_forum', 1, old('notify_forum', auth()->user()->notifications['notify_forum'])) !!}
                        Notify via email
                    </label>

                    <br><br>
                    @include('partials.v3.button', [
                        'type' => 'submit',
                        'element' => 'button',
                        'title' => translate('save_settings', 'Save settings'),
                        'class' => 'center'
                    ])
                @endcomponent


            </form>
        </div>

        <div class="col-md-6">

            @include('pages.v3.user._connect_accounts')

            @include('pages.v3.user._kick')

        </div>

    </div>



@endsection