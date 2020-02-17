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
        @endif
    </div>
</div>
@include('partials.frame.simple-bottom')