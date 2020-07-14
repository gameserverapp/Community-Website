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

            @if(isset($stat['data']) and isset($stat['options']))
                <div class="stat_canvas"
                     data-data='{!! json_encode($stat['data']) !!}'
                     data-options='{!!json_encode($stat['options'])!!}'></div>
            @endif
        </div>
    </div>
</article>
@include('partials.frame.simple-bottom')