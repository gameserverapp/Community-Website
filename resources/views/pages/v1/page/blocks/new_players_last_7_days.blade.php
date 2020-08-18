@include('partials.frame.simple-top')
<article>
    @if(isset($block['title']))
        <header class="row rownav">
            <div class="col-md-12">
                <div>
                    <h1 class="text-center">{{ $block['title'] }}</h1>
                </div>
            </div>
        </header>
    @endif

    <div class="row stat_block">
        <div class="col-md-12">
            <div class="stat_canvas" data-value="{{$value}}" data-route="{{route('stat.index', 'new-players-last-7-days')}}"><span>Loading...</span></div>
        </div>
    </div>
</article>
@include('partials.frame.simple-bottom')