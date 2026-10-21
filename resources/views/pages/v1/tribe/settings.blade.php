@extends('layouts.v2.banner', [
    'page' => [
        'title' => 'Settings - ' . $tribe->name,
        'description' => '',
        'class' => 'tribe log settings'
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
@endsection

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
                    <form method="post" action="{{route('tribe.settings.save', $tribe->id)}}">
                        {{csrf_field()}}
                        <div class="panel-body">

                            <strong>
                                Message of the Day
                            </strong>
                            <p class="small">
                                This is your {{ GameserverApp\Helpers\SiteHelper::groupName()}}'s MOTD. This will also be shown in-game, when a {{ GameserverApp\Helpers\SiteHelper::groupName()}}member logs in!
                            </p>
                            <textarea name="motd" class="form-control" placeholder="No MOTD yet...">{{ old('motd', $tribe->motd) }}</textarea>

                            <hr>

                            <strong>
                                'About' message
                            </strong>
                            <p class="small">
                                With the 'about' message you can leave a good impression to visitors
                            </p>
                            <textarea name="about" class="form-control" placeholder="About {{ $tribe->name }}...">{{ old('about', $tribe->about) }}</textarea>

                        </div>

                        <div class="panel-footer">
                            <input type="submit" class="btn champ small right" value="Save settings">
                        </div>

                    </form>
                </div>

                @include('partials.frame.simple-bottom')
            </div>


            <div class="col-md-4">
                @include('partials.frame.simple-top')
                <div class="discord panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            Connect your Discord server
                        </h3>
                    </div>

                    @if( $tribe->discordSetup() )
                        <form method="post" action="{{route('tribe.discord.save', $tribe->id)}}">
                            {{csrf_field()}}
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

                            <div class="alert alert-warning">
                                If the bot is not able to talk in the channel you select, it will disconnect.
                            </div>

                            <select name="channel_id">
                                <option value="-1"> - Select a Discord channel - </option>
                                @foreach($tribe->discord['available_channels'] as $id => $name)
                                    @if($tribe->discordChannelSetup() and $id == $tribe->discord['channel'])
                                        <option selected value="{{$id}}">{{$name}} [Current]</option>
                                    @else
                                        <option value="{{$id}}">{{$name}}</option>
                                    @endif
                                @endforeach
                            </select>
                            <input type="submit" class="btn champ small" value="Save channel">

                        @else
                            <div class="alert alert-warning">
                                <span class="indent">
                                    Not connected. <a href="{{$tribe->discordOAuthRedirectUrl()}}">Connect your account &raquo;</a>
                                </span>
                            </div>
                        @endif
                    </div>

                    @if( $tribe->discordSetup() )
                        </form>
                    @endif


                    @if( $tribe->discordSetup() )

                        <div class="panel-footer">
                            <form method="post" action="{{route('tribe.discord.disconnect', $tribe->id)}}">
                                {{csrf_field()}}
                                <div class="">
                                    <input type="submit" class="btn champ inverted small" value="Disconnect Discord">
                                </div>
                            </form>
                        </div>
                    @endif
                </div>
                @include('partials.frame.simple-bottom')
            </div>

        </div>
    </div>

@endsection