<{{$element ?? 'a'}} @isset($type) type="{{$type}}" @endisset @isset($route) href="{{$route}}" @endisset class="btn btn-theme {{$class ?? ''}}" @isset($dusk) dusk="{{$dusk}}" @endif >
    <span>{!! $title !!}</span>
</{{$element ?? 'a'}}>