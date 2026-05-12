<?php

use GameserverApp\Helpers\SiteHelper;

?>

@foreach(SiteHelper::customMenuItems() as $item)
    <li class="@if(isset($item->children) and is_array($item->children) and count($item->children)) has_child @endif">
        <a href="{{$item->url}}" @if($item->new_window) target="_blank"
           @endif class="{{ '/' . request()->path() == $item->url ? 'active' : '' }}">
            {{$item->title}}
        </a>

        @if(
            isset($item->children) and
            is_array($item->children) and
            count($item->children)
        )
            <ul class="submenu dropdown-menu">
                @foreach($item->children as $child)
                    <li class="@if(isset($child->children) and is_array($child->children) and count($child->children)) has_child @endif">
                        <a href="{{$child->url}}" @if($child->new_window) target="_blank"
                           @endif class="{{ '/' . request()->path() == $child->url ? 'active' : '' }}">
                            {{$child->title}}
                        </a>

                        @if(
                            isset($child->children) and
                            is_array($child->children) and
                            count($child->children)
                        )
                            <ul class="submenu dropdown-menu">
                                @foreach($child->children as $grandchild)
                                    <li>
                                        <a href="{{$grandchild->url}}" @if($grandchild->new_window) target="_blank"
                                           @endif class="{{ '/' . request()->path() == $grandchild->url ? 'active' : '' }}">
                                            {{$grandchild->title}}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </li>
                @endforeach
            </ul>
        @endif
    </li>
@endforeach