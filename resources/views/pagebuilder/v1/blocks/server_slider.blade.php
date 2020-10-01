<article class="server-slider"  id="servers">
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


    @if( GameserverApp\Helpers\RouteHelper::rules() )
        <div class="row rules">

            <div class="col-md-6 center-block">
                <div class="row">
                    <div class="col-sm-12 text-center">
                        <a href="{{GameserverApp\Helpers\RouteHelper::rules()}}" class="btn btn-theme">
                            <span>
                                Rules
                            </span>
                        </a>
                    </div>
                </div>
            </div>

        </div>
    @endif
</article>