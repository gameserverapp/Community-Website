@component('partials.v3.frame', ['title' => 'Special tools'])
    <p>
        If you're unable to join the server due to the "There is already a player with this account connected" bug, you can kick yourself from the server.
    </p>
    <br>

    {!! Form::model($user, ['route'=>['user.kick', auth()->id()]]) !!}

    @include('partials.v3.button', [
        'type' => 'submit',
        'element' => 'button',
        'title' => translate('kick_me', 'Kick me'),
        'class' => 'center btn-theme-gem'
    ])

    {!! Form::close() !!}
@endcomponent