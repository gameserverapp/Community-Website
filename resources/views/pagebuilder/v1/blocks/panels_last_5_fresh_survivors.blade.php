@component('partials.v3.frame', [
    'title' => '<i class="fa fa-hand-spock-o" aria-hidden="true"></i> Fresh survivors',
    'class' => 'no-padding center-title no-bottom-margin',
    'content_style' => 'min-height: 300px;'
])
    <table class="table">
        <thead>
        <tr>
            <th>Name</th>
            <th>Level</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
            @forelse( $characters as $character )
                <tr>
                    <td>
                        {!! $character->showLink([
                            'limit' => 13
                        ]) !!}
                    </td>
                    <td>
                        {{$character->level}}
                    </td>
                    <td>
                        {{str_replace('minute','min.',
                            str_replace('minutes','min.',
                                $character->date('created_at')->diffForHumans()
                            )
                        )}}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center">
                        <br><br>
                        No characters yet!
                        <br><br>
                        <br>
                    </td>
                </tr>
            @endforelse

            {{--<tr>--}}
                {{--<td colspan="4" class="text-right">--}}
                    {{--<a href="{{route('halloffame.newbies')}}">--}}
                        {{--See all newbies &raquo;--}}
                    {{--</a>--}}
                {{--</td>--}}
            {{--</tr>--}}

        </tbody>
    </table>
@endcomponent