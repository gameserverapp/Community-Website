<div class="col-md-12">
    <ul class="nav nav-tabs">
        @if( $character->user->hasCharacters() )
            @foreach( $character->user->characters as $char )

                <li class="character {{ GameserverApp\Helpers\RouteHelper::isCurrentRoute('character.show', $char->id) ? 'active' : '' }}">
                    <a href="{{route('character.show', $char->id)}}">
                        <div class="char_pic"
                             style="background-image:url('/img/character/{{$char->characterImage()}}')"></div>
                        {!! $char->showLink(['disable_link' => true]) !!}

                        @if($char->hasServer())
                            <span class="label label-default"><i class="hidden">[</i>{{$char->server->name}}<i class="hidden">]</i></span>
                        @endif
                    </a>
                </li>

            @endforeach
        @else
            <li class="filler"></li>
        @endif

    </ul>
</div>