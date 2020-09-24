
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
            {!! accountName(auth()->user(), 'small', null, null, 15) !!}
            <span class="caret"></span>
        </a>
        <ul class="dropdown-menu">
            <li>
                <a href="{{route('character.view', $navChar->uuid)}}" class="charview {{ isCurrentRoute('character.view', $navChar->uuid) ? 'orange' : '' }}">
                    <span>
                        {{$navChar->name}}
                    </span>
                    &nbsp;
                    <div class="char_pic"
                         style="background-image:url('/img/character/{{$navChar->image()}}')"></div>
                </a>
            </li>
            <li>
                @if($tribe = auth()->user()->getLastActiveTribe())
                    <a href="{{route('group.view', $tribe->uuid)}}"  class="{{ isCurrentroute('group.view', $tribe->uuid) ? 'orange' : '' }}">
                        {!! tribeName($tribe) !!}
                    </a>
                @else
                    <a href="/inspector?search_type=tribe">
                        Find a {{ GameserverApp\Helpers\SiteHelper::groupName()}} &raquo;
                    </a>
                @endif
            </li>

            <li role="separator" class="divider"></li>

            <li>
                <a href="{{route('news.index')}}" class="news {{ Request::is('news*') ? 'active' : '' }}">
                    News & Updates
                </a>
            </li>

            <li>
                <a href="{{route('page.features')}}" class="donator">
                    All features
                </a>
            </li>
            <li>
                <a href="{{route('page.rulesredirect')}}">
                    In-game rules
                </a>
            </li>
            <li>
                <a href="{{route('home')}}#servers">
                    Vote for Champion!
                </a>
            </li>

            @if( !auth()->user()->isVIP() )
                <li>
                    <a href="{{route('token.buy')}}">
                        Help the community <3
                    </a>
                </li>
            @endif

            <li role="separator" class="divider"></li>

            <li>
                <a href="{{route('token.index')}}" class="{{ isCurrentRoute('token.index') ? 'orange' : '' }}">
                    Tokens
                    <span class="label label-default right">
                        {{auth()->user()->tokenBalance()}}
                    </span>
                </a>
            </li>

            @if( config('championark.subscriptions.enabled') )
                <li>
                    <a href="{{route('account.subscription')}}">
                        Subscription

                        @if(auth()->user()->isP2PSubscriptionEndingShortly())
                            <span class="label label-danger right">
                                !
                            </span>
                        @elseif(auth()->user()->hasP2PSubscription())
                            <span class="label label-success right">
                                <i class="fa fa-check" aria-hidden="true"></i>
                            </span>
                        @endif
                    </a>
                </li>
            @endif

            <li>
                <a href="{{route('account.settings')}}" class="{{ isCurrentRoute('account.settings') ? 'orange' : '' }}">
                    Settings
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