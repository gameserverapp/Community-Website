<div data-id="{{$server->id}}" class="well @if($server->slots()) loaded @endif server-block-{{$server->id}} server-block {{$server->getCssClass()}}">

    @if($server->hasBackground())
    <div class="background" style="background-image:url('{{$server->background}}')"></div>
    @endif


        <div class="vote">
            @if(isset($status) and $server->hasVoteSites())
                <button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#voteServer{{$server->id}}">
                    <i class="fa fa-thumbs-up" aria-hidden="true"></i>
                    Vote
                </button>

                <!-- Modal -->
                <div class="modal fade" id="voteServer{{$server->id}}" tabindex="-1" role="dialog" aria-labelledby="voteServerLabel{{$server->id}}">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="myModalLabel">Vote for {{$server->name()}}</h4>
                            </div>
                            <div class="modal-body">

                                @if(!auth()->check())
                                    <div class="alert alert-danger">
                                        Please login to claim your vote.
                                    </div>
                                    <br>
                                @endif

                                <div class="row">

                                    @foreach($server->vote_sites as $site)
                                        <div class="col-md-6">
                                            <a href="{{$site->vote_url}}" target="_blank" class="btn btn-primary">
                                                @if($site->icon)
                                                    <img src="{{$site->icon}}" height="15" title="{{$site->name}}" />
                                                    &nbsp;
                                                @endif
                                                Vote on {{$site->name}}
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            @if(auth()->check())
                                <div class="modal-footer">
                                    <span>Claim your vote after voting</span>
                                    <form style="display:inline-block" method="post" action="{{route('server.claim-vote', $server->id)}}">
                                        {{csrf_field()}}
                                        <button class="btn btn-success btn-xs">Claim</button>
                                    </form>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
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

        @if(!isset($status) and !$server->slots())

            <span class="preload">
                <div class="loader"></div>
            </span>

        @elseif($server->isScheduled())
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

    <div class="server-block-content">

        <h2>{{$server->name()}}</h2>

        <div>

            <a href="steam://connect/{{$server->connectAddress()}}"
               class="btn btn-lg btn-default serverbtn grey">
                Click to launch game

                <i class="fa fa-forward"></i>
            </a>


        </div>

        <div class="help">


            @if($server->twitchSubOnly())
                <a href="{{route('user.settings', 'me')}}">
                    <span class="label label-champ p2p" target="_blank">Sub only</span>
                </a>
            @endif

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