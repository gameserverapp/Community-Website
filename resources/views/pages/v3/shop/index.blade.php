<?php
use GameserverApp\Helpers\SiteHelper;
?>

@extends('layouts.v3.default', [
    'page' => [
        'title' => translate('reward_shop', 'Reward shop'),
        'description' => 'Your orders are delivered in real-time.',
        'class' => 'shop'
    ],

    'breadcrumbs' => [
        [
            'title' => translate('reward_shop', 'Reward shop')
        ]
    ]
])

@section('page_content')

<div class="row">

    <div class="col-md-12 text-center">

        <div class="row">
            <div class="col-sm-8 center-block">
                <h1 class="title main-title">{{translate('reward_shop', 'Reward shop')}}</h1>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4 hidden-xs">
            </div>
            <div class="col-md-4 col-xs-8">
                <form method="get">
                    <input type="search" name="search" value="{{request()->get('search')}}" placeholder="Search...">
                    <input type="hidden" name="cluster" value="{{request()->get('cluster')}}">
                    <input type="hidden" name="gameserver" value="{{request()->get('gameserver')}}">
                    <input type="hidden" name="filter" value="{{request()->get('filter')}}">
                </form>
            </div>
            <div class="col-md-4 col-xs-4">

                <select onchange="if (this.value) window.location.href=this.value">
                    <option value="{{route('shop.index')}}?search={{request()->get('search')}}">No filter</option>

                    @if($filters)
                        <optgroup label="Filters">
                            @foreach($filters as $uuid => $name)
                                <option @if(urlencode(request()->get('filter')) == $uuid) selected @endif value="{{route('shop.index')}}?search={{request()->get('search')}}&filter={{$uuid}}">{{$name}}</option>
                            @endforeach
                        </optgroup>
                    @endif

                    @if($clusters)
                        <optgroup label="Items for specific cluster">
                            @foreach($clusters as $uuid => $name)
                                <option @if(request()->get('cluster') == $uuid) selected @endif value="{{route('shop.index')}}?search={{request()->get('search')}}&cluster={{$uuid}}">{{$name}}</option>
                            @endforeach
                        </optgroup>
                    @endif

                    @if($gameservers)
                        <optgroup label="Items for specific game server">
                            @foreach($gameservers as $id => $name)
                                <option @if(request()->get('gameserver') == $id) selected @endif value="{{route('shop.index')}}?search={{request()->get('search')}}&gameserver={{$id}}">{{$name}}</option>
                            @endforeach
                        </optgroup>
                    @endif
                </select>
            </div>
        </div>

    </div>
</div>
<br>
@if(request()->has('search'))
    <div class="row">
        <div class="col-md-8 center-block text-center">
            <h3 class="title">
                Results for "{{request()->get('search')}}"
            </h3>
        </div>
    </div>
@endif
<div class="row">

    @forelse( $packs as $pack )

        <div class="col-md-4 col-lg-3">
            @include('partials.v3.shop-package', [
                'item' => $pack
            ])
        </div>

    @empty
        <div class="col-md-12">
            <div class="text-center">
                <em>No packages available</em>
            </div>
        </div>
    @endforelse

</div>

<div class="row">
    <div class="paginate">
        {!! $packs->appends([
            'search' => request()->get('search'),
            'cluster' => request()->get('cluster'),
            'filter' => request()->get('filter')])->links() !!}
    </div>
</div>

@stop