@component('partials.v3.frame', ['title' => 'Connect with Patreon'])
    <div class="row">
        <div class="col-md-6">
            @if( auth()->user()->hasPatreonSetup() )
                <div class="alert alert-success">
                    <span class="indent">
                        Account <strong>{{auth()->user()->patreonUsername()}}</strong> connected
                    </span>
                </div>
            @else
                <p>
                    Connect your Patreon account to receive benefits for your pledge.
                </p>
            @endif
        </div>
        <div class="col-md-6">
            @if( auth()->user()->hasPatreonSetup() )

                {!! Form::model($user, ['route'=>['user.patreon.disconnect'], 'method' => 'post']) !!}
                @include('partials.v3.button', [
                    'type' => 'submit',
                    'element' => 'button',
                    'title' => translate('disconnect_patreon', 'Disconnect Patreon'),
                    'class' => 'center'
                ])
                {!! Form::close() !!}

            @else
                @include('partials.v3.button', [
                    'route' => route('user.patreon.connect'),
                    'title' => translate('connect_patreon', 'Connect Patreon'),
                    'class' => 'center'
                ])
            @endif
        </div>
    </div>

@endcomponent