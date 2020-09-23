@component('partials.v3.frame', [
    'title' => $block['title'],
    'class' => 'tiny-padding'
])
    <div class="stat_canvas" data-value="{{$value}}" data-route="{{route('stat.index', 'online-count-last-7-days')}}"><span>Loading...</span></div>
@endcomponent