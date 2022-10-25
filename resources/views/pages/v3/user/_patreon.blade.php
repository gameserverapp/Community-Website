@component('partials.v3.frame', ['title' => 'Connect your Patreon account'])
    <p>
        Connect your Patreon account to receive benefits for your pledge.
    </p>

    @if( auth()->user()->hasPatreonSetup() )

        <br>
        <div class="alert alert-success">
            <span class="indent">
                Patreon account <strong>{{auth()->user()->patreonUsername()}}</strong> connected
            </span>
        </div>

        <br>

        {!! Form::model($user, ['route'=>['user.patreon.disconnect'], 'method' => 'post']) !!}
            @include('partials.v3.button', [
                'type' => 'submit',
                'element' => 'button',
                'title' => translate('disconnect_patreon', 'Disconnect Patreon'),
                'class' => 'center'
            ])
        {!! Form::close() !!}

    @else
        <br>
        @include('partials.v3.button', [
            'route' => route('user.patreon.connect'),
            'title' => translate('connect_patreon', 'Connect Patreon'),
            'class' => 'center'
        ])
    @endif
@endcomponent