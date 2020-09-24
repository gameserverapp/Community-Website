<article class="spotlight ">

    <div class="row">
        <div class="col-md-12 text-center">
            <h1>
                Spotlight
            </h1>
        </div>
    </div>

    <div class="row">

        @forelse( $spotlight as $item )

            @if( $item instanceof GameserverApp\Models\Character )
                <div class="col-sm-6 col-md-4">
                    @include('partials.v3.character-card', [
                        'character' => $item
                    ])
                </div>
            @endif

            @if( $item instanceof GameserverApp\Models\Group )
                <div class="col-sm-6 col-md-4">
                    @include('partials.v3.group-card', [
                        'tribe' => $item
                    ])
                </div>
            @endif

        @empty
            <div class="col-md-12">
                <em>No spotlight items found</em>
            </div>
        @endforelse

    </div>

</article>