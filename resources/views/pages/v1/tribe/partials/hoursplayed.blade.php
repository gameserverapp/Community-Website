@include('partials.frame.simple-top')
<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">
            {{ ucfirst(GameserverApp\Helpers\SiteHelper::groupName())}} activities (hours played)
        </h3>
    </div>

    <div class="panel-body">

        <div class="stat_canvas"
             data-data='{!! json_encode($hoursPlayed['data']) !!}'
             data-options='{!!json_encode($hoursPlayed['options'])!!}'></div>
    </div>
</div>
@include('partials.frame.simple-bottom')