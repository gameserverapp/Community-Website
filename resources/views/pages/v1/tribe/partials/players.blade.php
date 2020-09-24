@include('partials.frame.simple-top')
<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">
            {!! $tribe->showName() !!}
        </h3>
    </div>

    @if( empty($characters) )
        <div class="panel-body">
            <em>No players..</em>
        </div>
    @else
        <table class="table">
            <thead>
            <tr>
                <th>Name</th>
                <th></th>
                @if($tribe->hasGame() and $tribe->game->supportLevel())
                    <th>Level</th>
                @endif
                <th width="10" class="hidden-xs"></th>
            </tr>
            </thead>
            <tbody>
            @foreach($characters as $char)
                <tr>
                    <td>
                        {!! $char->showLink() !!}
                    </td>
                    <td>
                        @if( $char->groupOwner($tribe) )
                            <span class="label label-default">Owner</span>
                        @elseif($char->groupAdmin($tribe))
                            <span class="label label-admin">Manager</span>
                        @endif
                    </td>
                    @if($tribe->hasGame() and $tribe->game->supportLevel())
                        <td>
                            {{$char->level}}
                        </td>
                    @endif
                    <td class="hidden-xs">
                        @if(
                            auth()->check() and
                            $char->user->id != auth()->user()->id
                        )
                            <a href="{{route('message.create', $char->user->id)}}" class="label label-admin">
                                Send message &raquo;
                            </a>
                        @endif
                    </td>
                </tr>
            @endforeach

            </tbody>
        </table>
    @endif
</div>
@include('partials.frame.simple-bottom')