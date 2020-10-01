@component('partials.v3.frame', ['title' => 'Connect your Discord'])
    <p>
        Connect your Discord server to receive the logs in your private Discord server.
    </p>

    @if( $group->discordSetup() )

        @if($group->discordChannelSetup())
            <div class="alert alert-success">
                <span class="indent">
                    Discord <strong>{{$group->discordServerName()}}</strong> connected
                </span>
            </div>
        @else
            <div class="alert alert-warning">
                <span class="indent">
                    Please select a channel to report to.<br>
                    <strong>Make sure the bot has access to the channel!</strong>
                </span>
            </div>
        @endif

        <div class="alert alert-warning">
            If the bot is not able to talk in the channel you select, it will disconnect.
        </div>

        <form method="post" action="{{route('group.discord.save', $group->id)}}">
            {{csrf_field()}}

            <select name="channel_id">
                <option> - Select a Discord channel - </option>
                @foreach($group->discord['available_channels'] as $id => $name)
                    @if($group->discordChannelSetup() and $id == $group->discord['channel'])
                        <option selected value="{{$id}}">{{$name}} [Current]</option>
                    @else
                        <option value="{{$id}}">{{$name}}</option>
                    @endif
                @endforeach
            </select>

            <br><br>

            @include('partials.v3.button', [
                'type' => 'submit',
                'element' => 'button',
                'title' => translate('save_channel', 'Save channel'),
                'class' => 'center btn-theme-rock'
            ])

        </form>

        <br>

        <form method="post" action="{{route('group.discord.disconnect', $group->id)}}">
            {{csrf_field()}}
            @include('partials.v3.button', [
                'type' => 'submit',
                'element' => 'button',
                'title' => translate('disconnect_discord', 'Disconnect Discord'),
                'class' => 'center'
            ])
        </form>

    @else
        <br>
        @if($group->isOwner(auth()->user()))
            @include('partials.v3.button', [
                'title' => translate('connect_discord', 'Connect Discord'),
                'route' => $group->discordOAuthRedirectUrl(),
                'class' => 'center btn-theme-rock'
            ])
        @else
            <div class="alert alert-warning">
                Only the owner of this group can connect the Discord server.
            </div>
        @endif
    @endif
@endcomponent