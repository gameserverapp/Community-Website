@component('partials.v3.frame', ['title' => 'Connect with Discord'])
    <div class="row">
        <div class="col-md-6">
            @if( auth()->user()->hasDiscordSetup() )
                <div class="alert alert-success">
                    <span class="indent">
                        Account <strong>{{auth()->user()->discordUsername()}}</strong> connected
                    </span>
                </div>
            @else
                <p>
                    Connect your Discord account to interact with <strong>GameServerApp Bot</strong>.
                </p>
            @endif
        </div>
        <div class="col-md-6">
            @if( auth()->user()->hasDiscordSetup() )

                {!! Form::model($user, ['route'=>['user.discord.disconnect'], 'method' => 'post']) !!}
                @include('partials.v3.button', [
                    'type' => 'submit',
                    'element' => 'button',
                    'title' => translate('disconnect_discord', 'Disconnect Discord'),
                    'class' => 'center'
                ])
                {!! Form::close() !!}

            @else
                @include('partials.v3.button', [
                    'route' => route('user.discord.connect'),
                    'title' => translate('connect_discord', 'Connect Discord'),
                    'class' => 'center'
                ])
            @endif
        </div>
    </div>



@endcomponent