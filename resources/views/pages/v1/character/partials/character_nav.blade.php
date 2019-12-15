<div class="container character_nav">
    <div class="row">
        <div class="col-md-12 text-center">

            @foreach( $user->character as $char )

                <a class="btn champ {{ Request::is('character/show/' . $char->uuid) ? '' : ' inverted dark' }}"
                   href="{{route('character.view', $char->uuid)}}">
                    {!! characterName($char) !!}
                    <span class="label label-default">{{$char->server->name}}</span>
                </a>

            @endforeach

        </div>
    </div>
    <hr>
</div>