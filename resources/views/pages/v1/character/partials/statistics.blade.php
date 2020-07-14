@forelse( $stats as $name => $stat )

    @if( $stat )
        @include('partials.frame.simple-top')
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">
                    {{$name}}
                </h3>
            </div>

            <div class="panel-body">

                @if(isset($stat['data']) and isset($stat['options']))
                    <div class="stat_canvas"
                         data-data='{!! json_encode($stat['data']) !!}'
                         data-options='{!!json_encode($stat['options'])!!}'></div>
                @endif
            </div>
        </div>
        @include('partials.frame.simple-bottom')
    @endif

@empty
    @include('partials.frame.simple-top')
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">
                No statistics yet
            </h3>
        </div>

        <div class="panel-body">
            Looks like there is to little data for this character
        </div>
    </div>
    @include('partials.frame.simple-bottom')
@endforelse
