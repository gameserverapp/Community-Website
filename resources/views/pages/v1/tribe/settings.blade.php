@extends('layouts.v2.banner', [
    'page' => [
        'title' => 'Settings - ' . $tribe->name,
        'description' => '',
        'class' => 'tribe log'
    ],
    'banner' => [
        'size' => 'small',
        'animated' => true,
        'text-only' => true,
        'vertical-align' => true,
        'navigation' => 'pages.v1.tribe.partials.navigation',
        'background' => [
            'tribe' => $tribe->bannerBackground()
        ]
    ]
])

@section('banner_content')
    @include('pages.v1.tribe.partials.banner')
@stop

@section('page_content')



    <div class="container defaultcontent">
        <div class="row">

            <div class="col-md-8">

                @include('partials.frame.simple-top')
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            {{ ucfirst(GameserverApp\Helpers\SiteHelper::groupName())}} settings
                        </h3>
                    </div>
                    <div class="panel-body">

                        {!! Form::model($tribe, ['route'=>['tribe.settings.save', $tribe->id]]) !!}

                        <strong>
                            Message of the Day
                        </strong>
                        <p class="small">
                            This is your {{ GameserverApp\Helpers\SiteHelper::groupName()}}'s MOTD. This will also be shown in-game, when a {{ GameserverApp\Helpers\SiteHelper::groupName()}}member logs in!
                        </p>
                        {!! Form::textarea('motd', old('motd'), array('class' => 'form-control', 'placeholder'=>'No MOTD yet...')) !!}

                        {{--<br>--}}
                        {{--{!! Form::checkbox('no-motd', 1, array('class' => 'form-control')) !!} No MOTD--}}

                        <hr>

                        <strong>
                            'About' message
                        </strong>
                        <p class="small">
                            With the 'about' message you can leave a good impression to visitors
                        </p>
                        {!! Form::textarea('about', old('about'), array('class' => 'form-control', 'placeholder'=>'About ' . $tribe->name . '...')) !!}

                    </div>

                    <div class="panel-footer">
                        {!! Form::submit('Save settings', array('class' => 'btn champ small right')) !!}
                    </div>

                    {!! Form::close() !!}
                </div>

                @include('partials.frame.simple-bottom')
            </div>


            <div class="col-md-4">
                @include('partials.frame.simple-top')
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            Connect your Discord server
                        </h3>
                    </div>

                    @if( $tribe->discordSetup() )
                    {!! Form::model($tribe, ['route'=>['tribe.discord.save', $tribe->id], 'method' => 'post']) !!}
                    @endif
                    <div class="panel-body">

                        <p>
                            Connect your Discord server to receive the logs in your private Discord server.
                        </p>

                        @if( $tribe->discordSetup() )


                            @if($tribe->discordChannelSetup())
                                <div class="alert alert-success">
                                    <span class="indent">
                                        Discord <strong>{{$tribe->discordServerName()}}</strong> connected
                                    </span>
                                </div>
                            @else
                                <div class="alert alert-warning">
                                    <span class="indent">
                                        Please select a channel to report to! <br>
                                        <strong>Make sure the bot has access to the channel!</strong>
                                    </span>
                                </div>
                            @endif

                            <select name="channel_id">
                                <option> - Select a Discord channel - </option>
                                @foreach($tribe->discord['available_channels'] as $id => $name)
                                    @if($tribe->discordChannelSetup() and $id == $tribe->discord['channel'])
                                        <option selected value="{{$id}}">{{$name}} [Current]</option>
                                    @else
                                        <option value="{{$id}}">{{$name}}</option>
                                    @endif
                                @endforeach
                            </select>

                        @else
                            <div class="alert alert-warning">
                                <span class="indent">
                                    Not connected. <a href="{{$tribe->discordOAuthRedirectUrl()}}">Connect your account &raquo;</a>
                                </span>
                            </div>
                        @endif
                    </div>


                    @if( $tribe->discordSetup() )

                    <div class="panel-footer">
                        {!! Form::submit('Save channel', array('class' => 'btn champ inverted  small')) !!}
                    </div>

                    {!! Form::close() !!}
                    @endif
                </div>
                @include('partials.frame.simple-bottom')
            </div>

        </div>
    </div>

@stop