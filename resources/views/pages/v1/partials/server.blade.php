<div data-id="{{$server->id}}" class="well server-block {{$server->getCssClass()}}">

    @if($server->hasBackground())
    <div class="background" style="background-image:url('{{$server->background}}')"></div>
    @endif

    <div class="content">

        <div class="vote">
            @if($server->twitchSubOnly())
                <a href="{{route('user.settings', 'me')}}">
                    <span class="label label-champ p2p" target="_blank">Sub only</span>
                </a>
            @elseif($server->p2p())
                @if(
                    auth()->check() and
                    $server->p2p() and
                    auth()->user()->isP2PSubscriptionEndingShortly()
                )
                    <a href="{{route('account.subscription')}}" class="label label-danger">
                        Subscription expires
                    </a>
                @else
                    <a href="{{route('account.subscription')}}">
                        <span class="label label-champ p2p" target="_blank">P2P</span>
                    </a>
                @endif
            @endif
        </div>

        @if($server->isScheduled())
            @if($server->isScheduledForUpdate())
                <span class="status_message">
                    @if( $server->date('update_at') > Carbon\Carbon::now() )
                        Automatic update: {{$server->date('update_at')->diffForHumans()}}
                    @else
                        Automatically updating & starting up...
                    @endif
                </span>
            @elseif($server->isScheduledForShutdown())
                <span class="status_message">
                    @if( $server->date('shutdown_at') > Carbon\Carbon::now() )
                        Shutdown: {{$server->date('shutdown_at')->diffForHumans()}}
                    @else
                        Shutdown in progress...
                    @endif
                </span>
            @elseif($server->isScheduledForRestart())
                <span class="status_message">
                    @if( $server->date('restart_at') > Carbon\Carbon::now() )
                        Restart: {{$server->date('restart_at')->diffForHumans()}}
                    @else
                        Restart in progress...
                    @endif
                </span>
            @endif
            <span class="status update"></span>
        @else
            <div class="version">
                @if(!empty($server->version))
                    v{{$server->version}}
                @endif
                @if($server->slots() !== false and $server->onlinePlayers() !== false)
                    &nbsp; &nbsp; <strong>{{$server->onlinePlayers()}}/{{$server->slots()}}</strong>
                @endif
            </div>

            @if( $server->online() )
                <span class="status online"></span>
            @elseif(!is_null($server->online()))
                <span class="status offline"></span>
            @endif
        @endif

        <h2>{{$server->name()}}</h2>

        <div>

            <a href="steam://connect/{{$server->connectAddress()}}"
               class="btn btn-lg btn-default serverbtn grey">
                Click to launch game

                <i class="fa fa-forward"></i>
            </a>


        </div>

        <div class="help">

            {{--todo link naar troubleshoot pagina--}}
            {{--<a href="{{route('support')}}" class="">--}}
            <span>
                {{$server->connectAddress()}}
            </span>

            @if(!empty($server->cluster_name))
                <span class="cluster_name">
                    // {{$server->cluster_name}}
                </span>
            @endif
            {{--</a>--}}


        </div>
    </div>

</div>