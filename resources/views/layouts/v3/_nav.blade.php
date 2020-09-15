<?php

use GameserverApp\Helpers\SiteHelper;
use Illuminate\Support\Facades\Cookie;

?>
<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-9 col-md-10 center-block">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                            data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <a class="navbar-brand" href="/"><h1>{{GameserverApp\Helpers\SiteHelper::name()}}</h1></a>
                </div>

                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">

                    <ul class="nav navbar-nav navbar-right">

                        @foreach(SiteHelper::customMenuItems() as $item)
                            <li class="@if(isset($item->children) and is_array($item->children)) has_child @endif">
                                <a href="{{$item->url}}" @if($item->new_window) target="_blank"
                                   @endif class="{{ '/' . request()->path() == $item->url ? 'active' : '' }}">
                                    {{$item->title}}
                                </a>

                                @if(isset($item->children) and is_array($item->children))
                                    <ul class="submenu dropdown-menu">
                                        @foreach($item->children as $child)
                                            <li>
                                                <a href="{{$child->url}}" @if($child->new_window) target="_blank"
                                                   @endif class="{{ '/' . request()->path() == $child->url ? 'active' : '' }}">
                                                    {{$child->title}}
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif
                            </li>
                        @endforeach

                        @if(auth()->check())
                            <li>
                                @include('layouts.v3.nav.member')
                            </li>
                        @else
                            <li>
                                <a href="{{route('auth.login')}}" class="btn btn-default btn-small login">
                                    <i class="fa fa-lock"></i>
                                    <span>
                                Login with <strong>STEAM</strong>
                            </span>
                                </a>
                            </li>
                        @endif

                        @if(GameserverApp\Helpers\RouteHelper::support() != false)
                            <li>
                                <a href="{{GameserverApp\Helpers\RouteHelper::support()}}" class="social-login">
                                    <span>Support</span>
                                </a>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>
</nav>
<div class="nav-filler"></div>