@component('partials.v3.frame', ['title' => 'Special tools'])
    <p>
        If you're unable to join the server due to the "There is already a player with this account connected" bug, you can kick yourself from the server.
    </p>
    <br>

    <form method="post" action="{{route('user.kick')}}">
        {{csrf_field()}}

        @include('partials.v3.button', [
            'type' => 'submit',
            'element' => 'button',
            'title' => translate('kick_me', 'Kick me'),
            'class' => 'center btn-theme-gem'
        ])

    </form>
@endcomponent