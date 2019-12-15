@include('partials.frame.simple-top')
<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">
            <i class="fa fa-trophy"></i>
            Top 5 characters
        </h3>
    </div>
    <table class="table">
        <thead>
        <tr>
            <th></th>
            <th>#</th>
            <th>Name</th>
            <th>Level</th>
            <th>Server</th>
        </tr>
        </thead>
        <tbody>
            <?php
            $count = 1;
            ?>
            @forelse( $characters['top'] as $character )
                <tr>
                    <td></td>
                    <td>{{$count}}</td>
                    <td>
                        {!! $character->showLink(['limit' => 13]) !!}
                    </td>
                    <td>{{$character->level}}</td>
                    <td>
                        @if($character->hasServer())
                            {{$character->server->name()}}
                        @endif
                    </td>
                </tr>

                <?php
                $count++;
                ?>
            @empty
                <tr>
                    <td colspan="5" class="text-center">
                        <br><br>
                        No characters yet!
                        <br><br>
                        <br>
                    </td>
                </tr>
            @endforelse

            {{--<tr>--}}
                {{--<td colspan="5" class="text-right">--}}
                    {{--<a href="{{route('halloffame.characters')}}">--}}
                        {{--See all top characters &raquo;--}}
                    {{--</a>--}}
                {{--</td>--}}
            {{--</tr>--}}
        </tbody>
    </table>
</div>
@include('partials.frame.simple-bottom')