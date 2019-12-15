<article class="container-fluid defaultcontent spotlight">
    <div class="container defaultcontent">

        <div class="row">
            <div class="col-md-12 title">
                <h1>
                    Spotlight
                </h1>
            </div>
        </div>

        <div class="row">

            @forelse( $spotlight as $item )

                @if( $item instanceof GameserverApp\Models\Character )
                    <div class="col-sm-4">
                        @include('pages.v1.partials.character-card', [
                            'character' => $item
                        ])
                    </div>
                @endif

                @if( $item instanceof GameserverApp\Models\Tribe )
                    <div class="col-sm-4">
                        @include('pages.v1.partials.tribe-card', [
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

    </div>
</article>