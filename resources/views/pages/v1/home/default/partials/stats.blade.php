<article class="container-fluid stats  fulldark">
    <div class="container defaultcontent">

        <div class="row ">
            <div class="col-md-12 text-center">
                <h1>
                    Population
                </h1>
            </div>
        </div>
        <br>

        <div class="row stat_block">
            @foreach( $stats as $name => $stat )

                @if( $stat )
                    <div class="col-md-{{$stat['col']}}">
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
                    </div>
                @endif

            @endforeach
        </div>

    </div>
</article>