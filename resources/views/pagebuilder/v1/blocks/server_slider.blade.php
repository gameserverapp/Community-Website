<article class="server-slider"  id="servers">
    <div class="row ">
        <div class="col-md-12 text-center">
            <h1>
                {{GameserverApp\Helpers\SiteHelper::name()}}
                @if(count($servers) == 1)
                    Server
                @else
                    Servers
                @endif
            </h1>
        </div>
    </div>
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