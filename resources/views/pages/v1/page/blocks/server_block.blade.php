<div class="servers no-slider">
    @forelse($servers as $server)
        @if($server->id == $value)
            @include('pages.v1.partials.server')
        @endif
    @empty

    @endforelse

    @forelse($servers as $server)
        @if($server->id == $value)
            @include('pages.v1.partials.server-vote')
        @endif
    @empty

    @endforelse
</div>