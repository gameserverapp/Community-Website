<?php
$title = 'Who\'s online?';

if($totalOnline == 1) {
    $title .= ' <span class="label label-theme alternative">1 player online</span>';
} else {
    $title .= ' <span class="label label-theme alternative">' . $totalOnline . ' players online</span>';
}
?>

@component('partials.v3.frame', [
    'title' => $title,
    'class' => 'no-padding center-title no-bottom-margin'
])
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

        @if( $characters->count() > 0 )

            @foreach( $characters->slice(0,5) as $character )
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
                            {{$character->server->name(10)}}
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
@endcomponent