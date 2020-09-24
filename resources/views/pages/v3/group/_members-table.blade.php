@component('partials.v3.frame', ['class' => 'no-padding members', 'type' => 'basic'])
    <table class="table table-striped">
        <thead>
        <tr>
            <th class="text-center">Name</th>
            <th class="text-center">Level</th>
            <th class="text-center">Rank</th>
        </tr>
        </thead>
        <tbody>
        @foreach($group->members as $char)
            <tr>
                <td>
                    <span class="image">
                        <img src="{{$char->image()}}" height="20">
                    </span>
                    {!! $char->showLink() !!}
                </td>
                <td class="text-center">
                    @if($group->hasGame() and $group->game->supportLevel())
                        {{$char->level}}
                    @endif
                </td>
                <td class="text-center">
                    @if( $char->groupOwner($group) )
                        Owner
                    @elseif($char->groupAdmin($group))
                        Manager
                    @endif
                </td>
            </tr>
        @endforeach

        </tbody>
    </table>
@endcomponent