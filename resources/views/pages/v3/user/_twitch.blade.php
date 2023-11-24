@component('partials.v3.frame', ['title' => 'Connect with Twitch'])
    <div class="row">
        <div class="col-md-6">

            @if( auth()->user()->isTwitchStreamer() )
                <div class="alert alert-success">
                    <span class="indent">
                        Account <strong>{{auth()->user()->twitchUsername()}}</strong> connected
                    </span>

                </div>
            @else
                <p>
                    Connect your Twitch account to access sub-only game servers.
                </p>
            @endif
        </div>
        <div class="col-md-6">

            @if( auth()->user()->isTwitchStreamer() )

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
                @include('partials.v3.button', [
                    'route' => route('user.twitch.connect'),
                    'title' => translate('connect_twitch', 'Connect Twitch'),
                    'class' => 'center'
                ])
            @endif
        </div>
    </div>


@endcomponent