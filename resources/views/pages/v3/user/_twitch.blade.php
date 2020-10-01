@component('partials.v3.frame', ['title' => 'Connect your Twitch account'])
    <p>
        Connect your Twitch.tv account if your community is using a Twitch sub whitelist or you want your stream on your character page when streaming.
    </p>

    @if( auth()->user()->isTwitchStreamer() )
        <br>
        <div class="alert alert-success">
            <span class="indent">
                Twitch account <strong>{{auth()->user()->twitchUsername()}}</strong> connected
            </span>
        </div>

        <br>
        {!! Form::model($user, ['route'=>['user.twitch.sync'], 'method' => 'post']) !!}

        @include('partials.v3.button', [
            'type' => 'submit',
            'element' => 'button',
            'title' => translate('twitch_sync', 'Sync Twitch'),
            'class' => 'center btn-theme-rock'
        ])

        {!! Form::close() !!}
        <br>

        {!! Form::model($user, ['route'=>['user.twitch.disconnect'], 'method' => 'post']) !!}

        @include('partials.v3.button', [
            'type' => 'submit',
            'element' => 'button',
            'title' => translate('disconnect_twitch', 'Disconnect Twitch'),
            'class' => 'center'
        ])

        {!! Form::close() !!}

    @else
        <br>
        @include('partials.v3.button', [
            'route' => route('user.twitch.connect'),
            'title' => translate('connect_twitch', 'Connect Twitch'),
            'class' => 'center'
        ])
    @endif
@endcomponent