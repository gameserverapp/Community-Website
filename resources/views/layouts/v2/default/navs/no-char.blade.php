@if( !Request::is('/') )
    <li class="hidden-sm">
        <a href="/">Home</a>
    </li>
@endif

<li>
    <a href="{{route('supplies.index')}}"
       class="{{ isCurrentRoute('supplies.index') ? 'active' : '' }}">
        Supplies
    </a>
</li>

<li>
    <a href="{{route('hoc.index')}}" class="{{ Request::is('hall-of-champions*') ? 'active' : '' }}">
        Hall of Champions
    </a>
</li>

<li>
    <a href="{{route('page.inspector')}}" class="{{ Request::is('inspector*') ? 'active' : '' }}">

        <i class="fa fa-search" aria-hidden="true"></i>
        Inspector
    </a>
</li>

<li>
    <a href="/forum" class="{{ Request::is('forum*') ? 'active' : '' }}">
        Forum
    </a>
</li>

<li class="hidden-sm">
    <a href="{{route('message.inbox')}}"
       class="inbox {{ ( Request::is('message/*')) ? 'active' : '' }}">
        Messages
        <span class="label label-default">
            {{auth()->user()->countUnreadMessages()}}
        </span>
    </a>
</li>

<li>
    <div class="dropdown">
        <a href="{{route('account.dashboard', auth()->user()->uuid)}}"
           class="btn btn-default btn-small dashboard" data-toggle="dropdown"
           aria-haspopup="true" aria-expanded="true">
            Account
            <span class="caret"></span>
        </a>
        <ul class="dropdown-menu">
            <li>
                <a href="{{route('page.serverinfo')}}" class="{{ isCurrentRoute('page.serverinfo') ? 'active' : '' }}">
                    Server information
                </a>
            </li>

            <li>
                <a href="{{route('page.features')}}" class="orange">See all features</a>
            </li>

            <li role="separator" class="divider"></li>


            <li>
                <a href="{{route('news.index')}}" class="news {{ Request::is('news*') ? 'active' : '' }}">
                    News & Updates
                </a>
            </li>

            <li>
                <a href="{{route('page.rulesredirect')}}">
                    In-game rules
                </a>
            </li>

            <li role="separator" class="divider"></li>

            <li>
                <a href="{{route('auth.logout')}}">
                    Logout
                </a>
            </li>
        </ul>
    </div>
</li>

<li>
    <a href="{{route('support')}}" class="social-login">
        <span>Support</span>
    </a>
</li>