@component('partials.v3.frame', ['title' => $block['title']])
    <div class="stat_canvas" data-value="{{$value}}" data-route="{{route('stat.index', 'hours-played-last-7-days')}}"><span>Loading...</span></div>
@endcomponent