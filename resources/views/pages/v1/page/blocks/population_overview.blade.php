
<div class="row ">
    <div class="col-md-12 text-center">
        <h1>
            Population
        </h1>
    </div>
</div>
<br>

<div class="row stat_block">
    @foreach( $stats as $stat )

        <div class="col-md-{{$stat['col']}}">
            @include('partials.frame.simple-top')
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        {{$stat['name']}}
                    </h3>
                </div>

                <div class="panel-body">
                    <div class="stat_canvas" data-value="" data-route="{{route('stat.index', $stat['route'])}}"><span>Loading...</span></div>
                </div>
            </div>
            @include('partials.frame.simple-bottom')
        </div>

    @endforeach
</div>