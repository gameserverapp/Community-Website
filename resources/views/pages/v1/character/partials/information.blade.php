<div class="row">
    <div class="col-md-12">
        @include('pages.v1.character.partials.information.character')
    </div>

    <div class="col-md-12">

        @if( $character->hasTribe() )
            @foreach($character->tribes as $tribe)
                @include('pages.v1.partials.tribe-card', [
                    'tribe' => $tribe
                ])
            @endforeach
        @else
            @include('pages.v1.character.partials.information.tribe')
        @endif
    </div>
</div>
