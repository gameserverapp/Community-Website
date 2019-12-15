@if( !Request::is('/') )
    <li class="hidden-sm hidden-md">
        <a href="/">Home</a>
    </li>
@endif

{{--<li>--}}
    {{--<a href="{{route('page.features')}}" class="hidden-sm {{ Request::is('website-features*') ? 'active' : '' }}">--}}
        {{--Features--}}
    {{--</a>--}}
{{--</li>--}}


{{--<li>--}}
    {{--<a href="{{route('hoc.index')}}" class="{{ Request::is('hall-of-champions*') ? 'active' : '' }}">--}}
        {{--Hall of Champions--}}
    {{--</a>--}}
{{--</li>--}}

{{--<li>--}}
    {{--<a href="{{route('page.inspector')}}" class="{{ Request::is('inspector*') ? 'active' : '' }}">--}}
        {{--<i class="fa fa-search" aria-hidden="true"></i>--}}
        {{--Inspector--}}
    {{--</a>--}}
{{--</li>--}}

{{--<li>--}}
    {{--<a href="/forum" class="{{ Request::is('forum*') ? 'active' : '' }}">--}}
        {{--Forum--}}
    {{--</a>--}}
{{--</li>--}}

<li>
    <a href="{{route('auth.login')}}" class="btn btn-default btn-small login">
        <i class="fa fa-lock"></i>
        <span>
            Login with <strong>STEAM</strong>
        </span>
    </a>
</li>

<li>
    <a href="{{route('page.steam')}}" class="social-login">
        <span>STEAM login?</span>
    </a>
</li>