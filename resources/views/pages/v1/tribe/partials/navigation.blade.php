<div class="col-sm-10 center-block ">
    <ul class="nav nav-tabs">

        <li class="{{ GameserverApp\Helpers\RouteHelper::isCurrentRoute('tribe.show', $tribe->id) ? 'active' : '' }}">
            <a href="{{route('tribe.show', $tribe->id)}}">
                {!! $tribe->showName() !!}
            </a>
        </li>

        <li class="{{ GameserverApp\Helpers\RouteHelper::isCurrentRoute('tribe.members', $tribe->id) ? 'active' : '' }}">
            <a href="{{route('tribe.members', $tribe->id)}}">
                Members
                <span class="badge">{{$tribe->countOnlineMembers()}} / {{$tribe->countAllMembers()}}</span>
            </a>
        </li>


        <li class="{{ GameserverApp\Helpers\RouteHelper::isCurrentRoute('tribe.statistics', $tribe->id) ? 'active' : '' }}">
            <a href="{{route('tribe.statistics', $tribe->id)}}">
                Statistics
            </a>
        </li>


        <li class="{{ GameserverApp\Helpers\RouteHelper::isCurrentRoute('tribe.log', $tribe->id) ? 'active' : '' }}">
            <a href="{{route('tribe.log', $tribe->id)}}">
                @if(
                    auth()->check() and
                    !auth()->user()->isTribeMember($tribe)
                )
                    <i class="fa fa-lock"></i>
                @endif
                Log
            </a>
        </li>

        @if(
            auth()->check() and
            auth()->user()->isTribeMember($tribe)
        )
            <li class="{{ GameserverApp\Helpers\RouteHelper::isCurrentRoute('tribe.promote', $tribe->id) ? 'active' : '' }}">
                <a href="{{route('tribe.promote', $tribe->id)}}">
                    Promote
                </a>
            </li>

            @if(
                $tribe->isOwner(auth()->user()) or
                $tribe->isAdmin(auth()->user())
            )
                <li class="settings {{ GameserverApp\Helpers\RouteHelper::isCurrentRoute('tribe.settings', $tribe->id) ? 'active' : '' }}">
                    <a href="{{route('tribe.settings', $tribe->id)}}">
                        Settings
                    </a>
                </li>
            @endif
        @endif

    </ul>
</div>