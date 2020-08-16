<div class="servers no-slider">
    @forelse($servers as $server)
        @if($server->id == $value)
            @include('pages.v1.partials.server')
        @endif
    @empty

    @endforelse
</div>