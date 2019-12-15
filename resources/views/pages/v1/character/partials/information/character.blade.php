@include('partials.frame.simple-top')
<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">
            {{$character->name()}}

            {!! $character->user->displayRoleLabel() !!}
        </h3>
    </div>
    <table class="table">
        <tbody>

        @if($character->game->supportLevel())
            <tr>
                <td>
                    Level
                </td>
                <td>
                    <strong>{{$character->level}}</strong>
                </td>
            </tr>
        @endif

        @if($character->game->supportGender())
            <tr>
                <td>
                    Gender
                </td>
                <td>
                    <strong>
                        @if($character->gender)
                            Male
                        @else
                            Female
                        @endif
                    </strong>
                </td>
            </tr>
        @endif

        <tr>
            <td>
                Server
            </td>
            <td>
                <strong>
                    {{$character->server->name()}}
                </strong>
            </td>
        </tr>

        @if(GameserverApp\Helpers\SiteHelper::featureEnabled('player_status'))
            @if( $character->date('status_since') > \Carbon\Carbon::now()->subWeeks(2) )

                <tr>
                    <td>
                        @if($character->online())
                            Online since
                        @else
                            Last online
                        @endif
                    </td>
                    <td>
                        <strong>
                            @if( !is_null( $character->status_since ) )
                                {{$character->date('status_since')->diffForHumans()}}
                            @else
                                Never
                            @endif
                        </strong>
                    </td>
                </tr>
            @endif
        @endif

        @if( $character->hoursPlayed() > 0.5 )
            <tr>
                <td>
                    Hours played
                </td>
                <td>
                    <strong>
                        {{$character->hoursPlayed()}}
                    </strong>
                </td>
            </tr>
        @endif

        <tr>
            <td>
                Created
            </td>
            <td>
                <strong>
                    {{$character->date('created_at')->diffForHumans()}}
                </strong>
            </td>
        </tr>

        <tr>
            <td>
                Owner
            </td>
            <td>
                <strong>
                    {!! $character->user->showLink(['disable_link' => true]) !!}
                </strong>
            </td>
        </tr>
        </tbody>
    </table>
</div>

@include('partials.frame.simple-bottom')