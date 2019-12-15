<div class="servers no-slider">
    @forelse($servers as $server)
        @if($server->id == $value)
        <div class="well server-block {{$server->getCssClass()}}">
            @include('pages.v1.partials.server')
        </div>
        @endif
    @empty

    @endforelse
</div>