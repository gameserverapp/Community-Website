<article class="col-sm-3 col-xs-6 online-character">
    <a href="{{route('character.show', $character->id)}}">
        <div class="picture_wrap" style="background-image:url('/img/character/{{$character->characterImage()}}')"></div>
        <h1>
            {!! $character->showName() !!} ({{$character->level}})
        </h1>
        @if($character->hasServer())
            <span class="label label-default">{{$character->server->name()}}</span>
        @endif
    </a>
</article>