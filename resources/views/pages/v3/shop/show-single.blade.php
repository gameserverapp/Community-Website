<?php
use GameserverApp\Helpers\SiteHelper;
?>

@extends('layouts.v3.default', [
    'page' => [
        'title' => $package->name(),
        'description' => $package->summary(),
        'class' => 'package-single',
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

        <form method="post" action="{{$package->orderUrl()}}">
            {{csrf_field()}}

            <div class="col-md-4">
                <div class="text-center">
                    <div class="main-image">
                        <img src="{{$package->image()}}">
                    </div>

                    @if($package->hasLabel())
                        <div class="label label-theme top-left">
                            {{$package->label()}}
                        </div>
                        <br>
                    @endif

                    <div class="hidden-md hidden-lg main-title">
                        <h1 class="title">
                        <span>
                            {{$package->name()}}
                        </span>
                        </h1>
                    </div>

                    <?php
                    $percentage = calcPercentage($package->limit(), $package->usage());
                    ?>

                    <div class="progress">
                        <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="20" aria-valuemin="0"
                             aria-valuemax="100" style="width: {{$percentage}}%">
                        </div>

                        <div class="detail">
                            {{$package->displayLimits()}}

                            @if($package->limit())
                                <i>({{$percentage}}%)</i>
                            @endif
                        </div>
                    </div>

                    @if($package->tokenPrice() > 0)
                        <p>
                            <strong>

                                @if($package->discount())
                                    Price<br>
                                    {!! $package->displayTokenPrice() !!}
                                @else
                                    Price: {!! $package->displayTokenPrice() !!}
                                @endif

                            </strong>
                        </p>
                    @endif
                </div>

                <div class=" hidden-sm hidden-xs">
                    @if(auth()->check())
                        <br>
                        <div class="row">
                            <div class="col-md-12 text-center">
                                @include('partials.v3.button', [
                                    'element' => 'button',
                                    'type' => 'submit',
                                    'title' => 'Order now &raquo;',
                                    'class' => 'btn-theme-rock'
                                ])
                            </div>

                            <div class="col-md-12 text-center">
                                <br>
                            </div>

                            <div class="col-md-12 text-center">
                                @if( SiteHelper::featureEnabled('tokens'))
                                    @include('partials.v3.button', [
                                        'route' => GameserverApp\Helpers\RouteHelper::token(),
                                        'title' => 'Get tokens',
                                    ])
                                @endif
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <div class="col-md-8">

                <div class="hidden-sm hidden-xs main-title">
                    <h1 class="title">
                        <span>
                            {{$package->name()}}
                        </span>
                    </h1>
                </div>
                <br>

                @component('partials.v3.frame', [
                    'type' => 'big'
                ])
                    {!! Markdown::convertToHtml($package->description()) !!}

                    @if(
                        $package->cluster or
                        $package->gameserver or
                        (
                            auth()->check() and
                            (
                                $package->requiresCharacterSelect()
                                or
                                (
                                    $package->requiresDiscordConnected() and
                                    !auth()->user()->hasDiscordSetup()
                                )
                            )
                        )
                    )
                        <hr>
                    @endif

                    @if($package->cluster)
                        <div class="alert alert-warning">
                            <span>
                                <i class="fa fa-exclamation-triangle" aria-hidden="true"></i>
                                Only deliverable on the <strong>{{$package->cluster}}</strong> cluster!
                            </span>
                        </div>
                    @endif

                    @if($package->gameserver)
                        <div class="alert alert-warning">
                            <span>
                                <i class="fa fa-exclamation-triangle" aria-hidden="true"></i>
                                Only deliverable on the <strong>{{$package->gameserver}}</strong> game server!
                            </span>
                        </div>
                    @endif

                    @if(auth()->check())
                        @if($package->requiresCharacterSelect())
                            @if($package->hasCharacters())
                                <div class="text-center">
                                    <label>Deliver to:</label>
                                    <select name="character_id">
                                        @foreach($package->characters() as $character)
                                            <option @if($character->online()) selected @endif value="{{$character->id}}">
                                                {{$character->name()}}

                                                @if($character->online()) [online] @endif

                                                @if($character->hasServer())
                                                    ({{$character->server->name}})
                                                @endif
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            @else
                                <div class="alert alert-danger">
                                    You do not have a character to deliver this shop pack to.
                                </div>
                            @endif
                        @elseif($package->requiresGameServerSelect())
                            @if($package->hasGameServers())
                                <div class="text-center">
                                    <label>Deliver on:</label>
                                    <select name="gameserver_id">
                                        @foreach($package->gameservers() as $gameserver)
                                            <option value="{{$gameserver->id}}" @if(old('gameserver_id') == $gameserver->id) selected @endif>
                                                {{$gameserver->name()}}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            @else
                                <div class="alert alert-danger">
                                    There are no game servers to deliver this shop pack on.
                                </div>
                            @endif
                        @endif
                    @endif
                @endcomponent


                @if(auth()->check())
                    <div class=" hidden-md hidden-lg">
                        <div class="row">
                            <div class="col-md-12 text-center">
                                @if(
                                    $package->requiresDiscordConnected() and
                                    !auth()->user()->hasDiscordSetup()
                                )
                                    <div class="alert alert-danger">
                                        You need to <a href="{{route('user.settings', auth()->user()->id)}}">connect your Discord</a> to order this package.
                                    </div>
                                    <br>
                                @else
                                    @include('partials.v3.button', [
                                        'element' => 'button',
                                        'type' => 'submit',
                                        'title' => 'Order now &raquo;',
                                        'class' => 'btn-theme-rock'
                                    ])
                                @endif
                            </div>

                            <div class="col-md-12 text-center">
                                <br>
                            </div>

                            <div class="col-md-12 text-center">
                                @if( SiteHelper::featureEnabled('tokens'))
                                    @include('partials.v3.button', [
                                        'route' => GameserverApp\Helpers\RouteHelper::token(),
                                        'title' => 'Get tokens',
                                    ])
                                @endif
                            </div>
                        </div>
                        <br>
                    </div>
                @else
                    <div class="alert alert-info">
                        Please <a href="{{route('auth.login')}}">login</a> to place an order.
                    </div>
                @endif
                <br>

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

        </form>
    </div>

@endsection