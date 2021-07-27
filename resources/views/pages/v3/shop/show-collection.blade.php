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

        <div class="col-md-8 center-block">
            <h2 class="text-center title main-title">
                <img src="{{$package->image()}}" alt="{{$package->image()}}">
                <span>
                    {{$package->name()}}
                </span>
            </h2>
            <div class="row">
                <div class="col-md-12">

                    @if($package->cluster)
                        <div class="alert alert-warning">
                            <span>
                                <i class="fa fa-exclamation-triangle" aria-hidden="true"></i>
                                Only deliverable on the <strong>{{$package->cluster}}</strong> cluster!
                            </span>
                        </div>
                        <br>
                    @endif

                    @component('partials.v3.frame', [
                        'type' => 'big'
                    ])
                        <h4>Order contents</h4>

                        {!! Markdown::convertToHtml($package->description()) !!}

                        @if(auth()->check() and $package->requiresCharacterSelect())
                            <hr>
                            @if($package->hasCharacters())
                                <div class="text-center">
                                    <label>Deliver to:</label>
                                    <select name="character_id">
                                        @foreach($package->characters() as $character)
                                            @if($character->status)
                                                <option selected value="{{$character->id}}">{{$character->name()}} [online]</option>
                                            @else
                                                <option value="{{$character->id}}">{{$character->name()}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            @else
                                <div class="alert alert-danger">
                                    You do not have a character to deliver this shop pack to.
                                </div>
                            @endif
                        @endif
                    @endcomponent


                    @if(auth()->check())

                        <div class="row">
                            <div class="col-md-8 center-block">


                                <div class="btnwrap text-center">

                                    <div class="row">
                                        <div class="col-md-6">
                                            @if( SiteHelper::featureEnabled('tokens'))
                                                @include('partials.v3.button', [
                                                    'route' => route('supporter-tier.index'),
                                                    'title' => 'Get tokens',
                                                ])
                                            @endif
                                        </div>
                                        <div class="col-md-6">
                                            @include('partials.v3.button', [
                                                'element' => 'button',
                                                'type' => 'submit',
                                                'title' => 'Order now &raquo;',
                                                'class' => 'btn-theme-rock'
                                            ])
                                        </div>
                                    </div>

                                </div>

                                <br>
                                <br>


                            </div>
                        </div>

                    @else
                        <div class="alert alert-info">Please <a href="{{route('auth.login')}}">login</a> to continue</div>
                    @endif

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
        </div>


    </div>

@stop