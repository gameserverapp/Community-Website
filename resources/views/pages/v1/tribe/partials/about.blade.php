@include('partials.frame.simple-top')
<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">
            About
            {!! $tribe->showName() !!}

            @if($tribe->hasServer())
                <div class="label label-default server">
                    {{$tribe->server->name()}}
                </div>
            @elseif($tribe->hasCluster())
                <div class="label label-default server">
                    {{$tribe->cluster->name()}}
                </div>
            @endif
        </h3>
    </div>
    <div class="panel-body">
        @if(!empty($tribe->about))
            {!! nl2br(e($tribe->about)) !!}
        @else
            <em>Nothing here...</em>

            {{--@if(--}}
                {{--auth()->check() and--}}
                {{--(--}}
                    {{--$tribe->hasOwner() and $tribe->owner_id == auth()->id()--}}
                {{--)--}}
            {{--)--}}
                {{--<br><br>--}}
                {{--<a href="{{route('group.settings', $tribe->id)}}">--}}
                    {{--Write a "about" message &raquo;--}}
                {{--</a>--}}
            {{--@endif--}}
        @endif
    </div>
</div>
@include('partials.frame.simple-bottom')