@include('partials.frame.simple-top')
<div class="img">
    <img width="{{$block['width'] or '100%'}}" height="{{$block['height'] or '100%'}}" src="{{$value}}">
</div>
@include('partials.frame.simple-bottom')