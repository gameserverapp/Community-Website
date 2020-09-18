@component('partials.v3.frame', ['title' => 'Connect your Discord account'])
    <p>
        Connect your Discord account to interact with <strong>GameServerApp Bot</strong> and receive notifications via DM.
    </p>

    @if( auth()->user()->hasDiscordSetup() )

        <br>
        <div class="alert alert-success">
            <span class="indent">
                Discord account <strong>{{auth()->user()->discordUsername()}}</strong> connected
            </span>
        </div>

        <br>

        {!! Form::model($user, ['route'=>['user.discord.disconnect'], 'method' => 'post']) !!}
            @include('partials.v3.button', [
                'type' => 'submit',
                'element' => 'button',
                'title' => translate('disconnect_discord', 'Disconnect Discord'),
                'class' => 'center'
            ])
        {!! Form::close() !!}

    @else
        <br>
        @include('partials.v3.button', [
            'route' => route('user.discord.connect'),
            'title' => translate('connect_discord', 'Connect Discord'),
            'class' => 'center'
        ])
    @endif
@endcomponent