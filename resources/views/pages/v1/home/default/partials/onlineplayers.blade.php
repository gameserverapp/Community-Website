@include('partials.frame.simple-top')
<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">
            Who's online?
            <span class="label label-default">
                @if( !$characters['online']->count() )
                    Nobody online
                @elseif($characters['online']->count() == 1)
                    1 player online
                @else
                    {{$characters['online']->count() }} players online
                @endif
            </span>
        </h3>
    </div>
    <table class="table">
        <thead>
        <tr>
            <th></th>
            <th>Name</th>
            <th>Level</th>
            <th>Playing on</th>
        </tr>
        </thead>
        <tbody>

        @if( $characters['online']->count() > 0 )

            @foreach( $characters['online']->slice(0,5) as $character )
                <tr>
                    <td></td>
                    <td>
                        {!! $character->showLink([
                            'limit' => 13
                        ]) !!}
                    </td>
                    <td>
                        {{$character->level}}
                    </td>
                    <td>
                        @if($character->hasServer())
                            {{$character->server->name()}}
                        @endif
                    </td>
                </tr>
            @endforeach

            {{--@if( count($characters['online']) > 5 )--}}
                {{--<tr>--}}
                    {{--<td colspan="4" class="text-right">--}}
                        {{--<a href="{{route('halloffame.online')}}">--}}
                            {{--See all online players &raquo;--}}
                        {{--</a>--}}
                    {{--</td>--}}
                {{--</tr>--}}
            {{--@endif--}}

        @else
            <tr>
                <td colspan="4" class="text-center">
                    <br><br>
                    Ow dear.. No characters online!
                    <br><br>
                    <br>
                </td>
            </tr>
        @endif

        </tbody>
    </table>
</div>
@include('partials.frame.simple-bottom')