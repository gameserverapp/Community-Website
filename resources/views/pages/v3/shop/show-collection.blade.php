<?php
use GameserverApp\Helpers\SiteHelper;
?>

@extends('layouts.v3.default', [
    'page' => [
        'title' => $package->name(),
        'description' => $package->summary(),
        'class' => 'package-collection',
        'attributes' => ''
    ],

    'breadcrumbs' => [
        [
            'title' => translate('reward_shop', 'Reward shop'),
            'route' => route('shop.index')
        ],
        [
            'title' => $package->name()
        ],
    ]
])

@section('page_content')

    <div class="row">
        <div class="col-md-4">
            <div class="text-center">
                <div class="main-image">
                    <img src="{{$package->image()}}">
                </div>

                @if($package->hasLabel())
                    <div class="label label-theme top-left">
                        {{$package->label()}}
                    </div>
                    <br><br>
                @endif

                <div class="main-title">
                    <h2 class="title">
                        <span>
                            {{$package->name()}}
                        </span>
                    </h2>
                </div>

                {!! Markdown::convertToHtml($package->description()) !!}
            </div>

            <div class=" hidden-sm hidden-xs">
                <br>
                <div class="row">
                    <div class="col-md-12 text-center">

                        @if(!auth()->check())
                            <div class="alert alert-info">
                                Please <a href="{{route('auth.login')}}">login</a> to place an order.
                            </div>
                            <br>
                        @endif

                        @if( SiteHelper::featureEnabled('tokens'))
                            @include('partials.v3.button', [
                                'route' => route('supporter-tier.index'),
                                'title' => 'Get tokens',
                            ])
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-8">

            <div class="options-title">
                <h2 class="title text-center">
                    <span>
                        Collection options
                    </span>
                </h2>
            </div>

            @forelse($package->children() as $child)
                @include('pages.v3.shop._collection-option', [
                    'item' => $child
                ])
            @empty
                <div class="alert alert-warning">

                    <em>This collection has no sub packages. Come back later...</em>
                </div>
                <br>
            @endif

            <div class=" hidden-lg hidden-md">
                @if(auth()->check())
                    <div class="row">
                        <div class="col-md-12 text-center">
                            @if( SiteHelper::featureEnabled('tokens'))
                                @include('partials.v3.button', [
                                    'route' => route('supporter-tier.index'),
                                    'title' => 'Get tokens',
                                ])
                            @endif
                        </div>
                    </div>
                    <br><br>
                @endif
            </div>

            @component('partials.v3.frame', ['type' => 'basic'])
                <div class="row">
                    <div class="col-md-6">
                        <h6>When do I get it?</h6>
                        <p>
                            Your order is delivered automatically when you are online. This usually takes less than 1 minute. You're notified in-game about the status.
                        </p>
                    </div>
                    <div class="col-md-6">
                        <h6>I'm not online right now</h6>
                        <p>
                            The delivery system will wait for your to come online. You have 7 days to pick up your order.
                        </p>
                    </div>
                </div>
            @endcomponent

        </div>

    </div>

@stop