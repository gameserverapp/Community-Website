<?php
use GameserverApp\Helpers\SiteHelper;
?>

@extends('layouts.v3.default', [
    'page' => [
        'title' => translate('shop', 'Shop'),
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
            <div class="col-sm-4">

            </div>
            <div class="col-sm-4">

                <h1 class="title">{{translate('reward_shop', 'Reward shop')}}</h1>
                @if($categories)
                    <select onchange="if (this.value) window.location.href=this.value">
                        <option value="{{route('shop.index')}}">All packages</option>

                        <option @if(request()->get('category') == 'no-cluster') selected @endif value="{{route('shop.index')}}?category=no-cluster">All packages without cluster restriction</option>
                        <optgroup label="Packages for specific cluster">
                            @foreach($categories as $uuid => $name)
                                <option @if(request()->get('category') == $uuid) selected @endif value="{{route('shop.index')}}?category={{$uuid}}">{{$name}}</option>
                            @endforeach
                        </optgroup>
                    </select>
                @endif
            </div>
            <div class="col-sm-4">

            </div>
        </div>


    </div>
</div>
<br>
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

    <div class="paginate">
        {!! $packs->links() !!}
    </div>

</div>

@stop