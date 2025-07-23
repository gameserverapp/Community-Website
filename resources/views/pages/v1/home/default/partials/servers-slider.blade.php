<article class="container defaultcontent servers"  id="servers">
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
                <div class="item">
                    @include('pages.v1.partials.server', [
                        'slider' => true
                    ])
                </div>
            @empty
                <div class="item">
                    <div class="well server-block ">
                        <div>
                            <span class="status online"></span>

                            <h2>Demo server</h2>

                            <div>
                                <a href="#" class="btn btn-lg btn-default serverbtn grey">
                                    Click to launch game
                                    <i class="fa fa-forward"></i>
                                </a>
                            </div>

                            <div class="help">
                                <span class="cluster_name">Cluster-1</span>
                            </div>
                        </div>
                    </div>
                </div>
            @endforelse
        </div>


        @foreach($servers as $server)
            @include('pages.v1.partials.server-vote', [
                'server' => $server
            ])
        @endforeach
    </div>
</article>