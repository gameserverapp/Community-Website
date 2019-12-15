@extends('layouts.v2.banner', [
    'page' => [
        'title' => 'Dashboard - ' . $user->name,
        'description' => '',
        'class' => 'account settings'
    ],
    'banner' => [
        'size' => 'small',
        'text-only' => true,
        'vertical-align' => true,

    ]
])


@section('banner_content')
    Your settings
@stop

@section('page_content')



    <div class="container defaultcontent">
        <div class="row">

            {!! Form::model($user, ['route'=>['user.settings.store', auth()->id()], 'method' => 'store']) !!}
            <div class="col-md-8">
                @include('partials.frame.simple-top')
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            Notifications
                        </h3>
                    </div>
                    <div class="panel-body">

                        <strong>
                            Your e-mail address
                        </strong>
                        <p>
                            On which e-mail address would you like to be notified?
                        </p>
                        {!! Form::email('email', old('email', auth()->user()->notifications['email']), array('class' => 'form-control', 'placeholder'=>'Your e-mail address')) !!}

                        <br>
                        @if(auth()->user()->hasEmailSetup() and !auth()->user()->emailConfirmed())
                            <div class="alert alert-warning">
                                <strong>Please confirm your e-mail address by clicking the link in the confirmation e-mail.</strong> <a href="{{route('user.confirm_email.resend', $user->id)}}">Resend confirmation</a>
                            </div>
                            <br>
                        @endif
                        <div class="alert alert-info">
                            <strong>We hate spam, just like you!</strong>
                            Your e-mail address is stored in the GameserverApp.com database and will only be used for alerts, which you can choose below. Your e-mail address will <u>not</u> be sold to 3rd parties.
                        </div>
                        <br>
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
                                    Notify via e-mail
                                </label>
                            </div>

                        </div>

                        {{--
                        <hr>

                        <strong>
                            When someone replies to a forum thread you follow
                        </strong>
                        <p class="small">
                            You can subscribe and unsubscribe to forum threads
                        </p>
                        <div class="row">
                            <div class="col-md-3">
                                <label>
                                    {!! Form::checkbox('notify_forum', 1, old('notify_forum', auth()->user()->notifications['notify_forum'])) !!}
                                    Notify me by e-mail
                                </label>
                            </div>

                        </div> --}}

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
                                    Notify via e-mail
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
                                    Notify via e-mail
                                </label>
                            </div>

                        </div>

                        {{--
                        <hr>

                        <strong>
                            Events
                        </strong>
                        <p class="small">
                            You will receive an e-mail when there is an event coming up.
                        </p>
                        <div class="row">
                            <div class="col-md-3">
                                <label>
                                    {!! Form::checkbox('notify_event', true, old('notify_event')) !!}
                                    Notify me by e-mail
                                </label>
                            </div>

                        </div>

                        <hr>

                        <strong>
                            Scheduled maintance
                        </strong>
                        <p class="small">
                            When we schedule maintenance, you will know.
                        </p>
                        <div class="row">
                            <div class="col-md-3">
                                <label>
                                    {!! Form::checkbox('notify_admin', true, old('notify_admin')) !!}
                                    Notify me by e-mail
                                </label>
                            </div>

                        </div>

                        --}}
                    </div>
                    <div class="panel-footer">
                        {!! Form::submit('Save all settings', array('class' => 'btn champ small right')) !!}
                    </div>
                </div>
                @include('partials.frame.simple-bottom')

            </div>


            {!! Form::close() !!}

            <div class="col-md-4">

                @if( config('championark.subscriptions.enabled') )
                    <div class="panel panel-warning">
                        <div class="panel-heading">
                            <h3 class="panel-title">
                                Champion Subscription
                            </h3>
                        </div>
                        <div class="panel-body">
                            <p>
                                Being a Champion Subscriber gives you access to the <strong>Pay-2-Play server(s)</strong>.
                            </p>

                            @if($user->hasP2PSubscription())
                                Your subscription expires:
                                @if( $user->isP2PSubscriptionEndingShortly() )
                                    <span class="label label-danger">
                                        {{$user->displayP2PSubscriptionTimeLeft()}}
                                    </span>
                                @else
                                    <span class="label label-success">
                                        {{$user->displayP2PSubscriptionTimeLeft()}}
                                    </span>
                                @endif

                            @else
                                <i>No active subscription</i>
                            @endif

                            <br><br>
                            <div class="text-center">
                                <a href="{{route('account.subscription')}}" class="btn champ small inverted dark">Subscription options &raquo;</a>
                            </div>

                        </div>
                    </div>
                @endif

                @include('partials.frame.simple-top')
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            Connect your Twitch.tv account
                        </h3>
                    </div>
                    <div class="panel-body">

                        <p>
                            Connect your Twitch.tv account if your community is using a Twitch sub whitelist or you want your stream on your character page when streaming.
                        </p>

                        @if( auth()->user()->isTwitchStreamer() )

                            <div class="alert alert-success">
                                <span class="indent">
                                    Twitch account <strong>{{auth()->user()->twitchUsername()}}</strong> connected
                                </span>
                            </div>

                            <br>
                        <div class="row">
                            <div class="col-md-6">
                                {!! Form::model($user, ['route'=>['user.twitch.sync'], 'method' => 'post']) !!}
                                <div class="text-left">
                                    {!! Form::submit('Sync', array('class' => 'btn champ grey  small')) !!}
                                </div>
                                {!! Form::close() !!}
                            </div>
                            <div class="col-md-6">
                                {!! Form::model($user, ['route'=>['user.twitch.disconnect'], 'method' => 'post']) !!}
                                <div class="text-right">
                                    {!! Form::submit('Disconnect Twitch', array('class' => 'btn champ inverted  small')) !!}
                                </div>
                                {!! Form::close() !!}
                            </div>
                        </div>


                        @else
                            <div class="alert alert-warning">
                                <span class="indent">
                                    Not connected. <a href="{{route('user.twitch.connect')}}">Connect your account &raquo;</a>
                                </span>
                            </div>
                        @endif
                    </div>
                </div>
                @include('partials.frame.simple-bottom')

                @include('partials.frame.simple-top')
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            Special tools
                        </h3>
                    </div>
                    <div class="panel-body">
                        <p>
                            If you're unable to join the server due to the "There is already a player with this account connected" bug, you can kick yourself from the server.
                        </p>

                        {!! Form::model($user, ['route'=>['user.kick', auth()->id()]]) !!}

                        {!! Form::submit('Kick me!', array('class' => 'btn champ small right')) !!}

                        {!! Form::close() !!}

                    </div>
                </div>
                @include('partials.frame.simple-bottom')
            </div>
        </div>

    </div>




@stop