<?php
use Illuminate\Support\Str;
?>
<ol class="breadcrumb">
    <li>
        <a href="/">Home</a>
    </li>
    @foreach($breadcrumbs as $breadcrumb)
        @isset($breadcrumb['route'])
            <li><a href="{{$breadcrumb['route']}}">{{Str::limit($breadcrumb['title'], 30)}}</a></li>
        @else
            <li class="active"><span>{{Str::limit($breadcrumb['title'], 30)}}</span></li>
        @endisset
    @endforeach
</ol>
