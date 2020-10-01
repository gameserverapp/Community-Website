<div class="col-sm-10 center-block ">
    <ul class="nav nav-tabs">

        <li class="{{ GameserverApp\Helpers\RouteHelper::isCurrentroute('group.show', $tribe->id) ? 'active' : '' }}">
            <a href="{{route('group.show', $tribe->id)}}">
                {!! $tribe->showName() !!}
            </a>
        </li>

        <li class="{{ GameserverApp\Helpers\RouteHelper::isCurrentroute('group.members', $tribe->id) ? 'active' : '' }}">
            <a href="{{route('group.members', $tribe->id)}}">
                Members
                <span class="badge">{{$tribe->countOnlineMembers()}} / {{$tribe->countAllMembers()}}</span>
            </a>
        </li>


        <li class="{{ GameserverApp\Helpers\RouteHelper::isCurrentroute('group.statistics', $tribe->id) ? 'active' : '' }}">
            <a href="{{route('group.statistics', $tribe->id)}}">
                Statistics
            </a>
        </li>


        <li class="{{ GameserverApp\Helpers\RouteHelper::isCurrentroute('group.log', $tribe->id) ? 'active' : '' }}">
            <a href="{{route('group.log', $tribe->id)}}">
                @if(
                    auth()->check() and
                    !auth()->user()->isGroupMember($tribe)
                )
                    <i class="fa fa-lock"></i>
                @endif
                Log
            </a>
        </li>

        @if(
            auth()->check() and
            auth()->user()->isGroupMember($tribe)
        )
            <li class="{{ GameserverApp\Helpers\RouteHelper::isCurrentroute('group.promote', $tribe->id) ? 'active' : '' }}">
                <a href="{{route('group.promote', $tribe->id)}}">
                    Promote
                </a>
            </li>

            @if(
                $tribe->isOwner(auth()->user()) or
                $tribe->isAdmin(auth()->user())
            )
                <li class="settings {{ GameserverApp\Helpers\RouteHelper::isCurrentroute('group.settings', $tribe->id) ? 'active' : '' }}">
                    <a href="{{route('group.settings', $tribe->id)}}">
                        Settings
                    </a>
                </li>
            @endif
        @endif

    </ul>
</div>