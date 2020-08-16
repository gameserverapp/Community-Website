<?php
use GameserverApp\Helpers\SiteHelper;use Illuminate\Support\Facades\Cookie;
?>

@if( !Request::is('/') )
    <li class="hidden-sm">
        <a href="/">Home</a>
    </li>
@endif

@foreach(SiteHelper::customMenuItems() as $item)
    <li class="@if(isset($item->children) and is_array($item->children)) has_child @endif">
        <a href="{{$item->url}}" @if($item->new_window) target="_blank" @endif class="{{ '/' . request()->path() == $item->url ? 'active' : '' }}">
            {{$item->title}}
        </a>

        @if(isset($item->children) and is_array($item->children))
            <ul class="submenu dropdown-menu">
                @foreach($item->children as $child)
                    <li>
                        <a href="{{$child->url}}" @if($child->new_window) target="_blank" @endif class="{{ '/' . request()->path() == $child->url ? 'active' : '' }}">
                            {{$child->title}}
                        </a>
                    </li>
                @endforeach
            </ul>
        @endif
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