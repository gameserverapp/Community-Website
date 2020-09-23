
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
            @component('partials.v3.frame', ['title' => $stat['name'], 'class' => 'tiny-padding'])
                <div class="stat_canvas" data-value="" data-route="{{route('stat.index', $stat['route'])}}"><span>Loading...</span></div>
            @endcomponent
        </div>

    @endforeach
</div>