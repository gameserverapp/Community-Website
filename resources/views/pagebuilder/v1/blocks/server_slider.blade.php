<article class="server-slider" id="servers">
    @if(isset($block['title']) and !empty($block['title']))
        <div class="row">
            <div class="col-md-12 text-center">
                <h1>
                    {{$block['title']}}
                </h1>
            </div>
        </div>
    @endif
    <div class="row">
        <div class=" owl-theme" id="serverSlider">
            @forelse($servers as $server)
                <div class="server-container">
                    @include('partials.v3.server', [
                        'slider' => true
                    ])
                </div>
            @empty

            @endforelse
        </div>
    </div>
</article>