<?php
use GameserverApp\Helpers\SiteHelper;
?>

@if( !Request::is('/') )
    <li class="hidden-sm">
        <a href="/">Home</a>
    </li>
@endif

@foreach(SiteHelper::customMenuItems() as $item)
    <li>
        <a href="{{$item->url}}" @if($item->new_window) target="_blank" @endif class="{{ '/' . request()->path() == $item->url ? 'active' : '' }}">
            {{$item->title}}
        </a>
    </li>
@endforeach

@if(SiteHelper::featureEnabled('inspector'))
<li>
    <a href="{{route('inspector.index')}}" class="{{ Request::is('inspector*') ? 'active' : '' }}">
        <i class="fa fa-search" aria-hidden="true"></i>
        Inspector
    </a>
</li>
@endif

@if(auth()->check())

    @if(SiteHelper::featureEnabled('messages'))
        <li class="hidden-sm">
            <a href="{{route('message.index')}}"
               class="inbox {{ ( Request::is('message/*')) ? 'active' : '' }}">
                Messages
            <span class="label label-default">
               {{auth()->user()->unreadMessagesCount()}}
            </span>
            </a>
        </li>
    @endif
    <li>
        @include('layouts.v2.default.navs.sub.member')
    </li>
@else
    <li>
        @include('layouts.v2.default.navs.sub.guest')
    </li>
@endif

@if(GameserverApp\Helpers\RouteHelper::support() != false)
    <li>
        <a href="{{GameserverApp\Helpers\RouteHelper::support()}}" class="social-login">
            <span>Support</span>
        </a>
    </li>
@endif