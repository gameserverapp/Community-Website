@include('partials.frame.simple-top')
<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">
            <i class="fa fa-bullhorn"></i>
            Message of the day
        </h3>
    </div>
    <div class="panel-body">
        @if(!empty($tribe->motd))
            {!! nl2br(e($tribe->motd)) !!}
        @else
            <em>Nothing here...</em>

            @if( $tribe->hasOwner() and 1 == 2 )
                <br><br>
                <a href="{{route('tribe.settings', $tribe->id)}}">
                    Set a MOTD &raquo;
                </a>
            @endif
        @endif
    </div>
</div>
@include('partials.frame.simple-bottom')