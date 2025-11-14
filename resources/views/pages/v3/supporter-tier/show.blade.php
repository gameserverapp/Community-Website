@extends('layouts.v3.default', [
    'page' => [
        'title' => $package->name(),
        'description' => $package->summary(),
        'class' => 'package-single supporter-tier',
        'attributes' => ''
    ],

    'breadcrumbs' => [
        [
            'title' => translate('supporter_tiers', 'Supporter tiers'),
            'route' => route('supporter-tier.index')
        ],
        [
            'title' => $package->name()
        ],
    ]
])

@section('page_content')

    <div class="row">

        <div class="col-md-8 center-block">
            <h2 class="text-center main-title">


                @if($package->hasLabel())
                    <div class="label label-theme top-left">
                        {{$package->label()}}
                    </div>
                    <br>
                @endif

                <img src="{{$package->image()}}"
                     alt="{{$package->image()}}">
                {{$package->name()}}
            </h2>

            <div class="row">
                <div class="col-md-12">

                    @if(auth()->check())
                        @if($package->requiresDiscordSetup() and !auth()->user()->hasDiscordSetup())
                            <div class="alert alert-danger">
                                You need to <a href="{{route('user.settings', auth()->user()->id)}}">setup your Discord</a> to receive this package.
                            </div>
                            <br>
                        @endif
                    @endif

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

                        <br>

                        <div class="row">
                            <div class="col-lg-8 col-md-6">

                                @if($package->discount())
                                    <h4>
                                        @if($package->isSubscription())
                                            Costs
                                        @else
                                            Price
                                        @endif

                                        @if($package->hasLabel())
                                            <div class="label label-theme top-left">
                                                {{$package->label()}}
                                            </div>
                                        @endif
                                    </h4>
                                    <p>
                                        <strong>
                                            {!! $package->displayTotalPrice() !!}
                                        </strong>
                                    </p>
                                @else
                                    <p>
                                        <strong>
                                            @if($package->isSubscription())
                                                Costs:
                                            @else
                                                Total:
                                            @endif

                                            {!! $package->displayTotalPrice() !!}
                                        </strong>
                                    </p>
                                @endif



                            </div>
                            <div class="col-lg-4  col-md-6 coupon">

                                <h4>Discount code:</h4>
                                <form method="get">
                                    <div class="input-group">
                                        <input class="form-control" name="coupon" type="text" value="{{request('coupon', '')}}" placeholder="Enter your discount code">
                                        <span class="input-group-btn">
                                            <button class="btn btn-default" type="submit" dusk="apply-coupon">Apply</button>
                                        </span>
                                    </div>
                                </form>

                            </div>
                        </div>

                    @endcomponent

                    @if(auth()->check())
                        <form method="get" action="{{$package->orderUrl()}}">

                            @if(request()->has('coupon'))
                                <input type="hidden" name="coupon" value="{{request('coupon')}}">
                            @endif

                            @if($package->isSubscription())
                                <div class="alert alert-success">
                                    <span>
                                        <i class="fa fa-check" aria-hidden="true"></i>
                                        You can easily stop automatic renewal at any moment.
                                    </span>
                                </div>
                            @endif

                            @if($package->requiresCharacter())
                                <div class="row">
                                    <div class="col-lg-6 center-block">
                                        @if($package->hasCharacters())
                                            <label>Deliver to:</label>
                                            <select name="character_id">
                                                <option value="">Select a character</option>
                                                @foreach($package->characters() as $character)
                                                    <option @if($character->online()) selected @endif value="{{$character->id}}">
                                                        {{$character->name()}}

                                                        @if($character->online())
                                                            [online]
                                                        @endif

                                                        @if($character->hasServer())
                                                            ({{$character->server->name}})
                                                        @endif
                                                    </option>
                                                @endforeach
                                            </select>
                                        @else
                                            <div class="alert alert-danger">
                                                You must have a character to order this package.
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @elseif($package->requiresGameserver())
                                <div class="row">
                                    <div class="col-lg-6 center-block">
                                        @if($package->hasGameservers())
                                            <label>Deliver on:</label>
                                            <select name="gameserver_id">

                                                <?php
                                                $selectServer = old('gameserver_id');

                                                if($package->hasCharacters()) {
                                                    $onlineCharacter = $package->characters()->filter(function($character) {
                                                        return $character->online();
                                                    })->first();

                                                    if($onlineCharacter) {
                                                        $selectServer = $onlineCharacter->server->id;
                                                    }
                                                }
                                                ?>

                                                <option value="">Select a game server</option>
                                                @foreach($package->gameservers() as $server)
                                                    <option value="{{$server->id}}"  @if($selectServer == $server->id) selected @endif>
                                                        {{$server->name()}}
                                                    </option>
                                                @endforeach
                                            </select>
                                        @else
                                            <div class="alert alert-danger">
                                                You must select a game server to order this package.
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endif

                            @if($package->hasPaymentProviders())

                                @if(
                                    (
                                        !$package->requiresCharacter() or
                                        (
                                            $package->requiresCharacter() and
                                            $package->hasCharacters()
                                        )
                                    ) and
                                    (
                                        !$package->requiresGameserver() or
                                        (
                                            $package->requiresGameserver() and
                                            $package->hasGameservers()
                                        )
                                    )
                                )
                                    <div class="row">
                                        <div class="col-lg-6 center-block">
                                            <label>Pay via:</label>

                                            <select name="psp" class="form-control">

                                                @foreach($package->paymentProviders() as $id => $psp)

                                                    @if($psp->active)
                                                        <option value="{{$id}}" @if($psp->default) selected @endif>Pay with {{$psp->name}}</option>
                                                    @endif
                                                @endforeach
                                            </select>

                                        </div>
                                    </div>

                                    <div class="btnwrap text-center">
                                        <?php
                                        if($package->isSubscription()) {
                                            $text = 'Subscribe';
                                        } else {
                                            $text = 'Order';
                                        }
                                        ?>

                                        @include('partials.v3.button', [
                                            'element' => 'button',
                                            'type' => 'submit',
                                            'title' => $text . ' &raquo;',
                                            'class' => 'btn-theme-rock',
                                            'dusk' => 'order-button'
                                        ])
                                    </div>
                                @endif
                            @else
                                <div class="alert alert-warning">
                                    The shop configurations are not properly set up yet. Please contact the community owner.
                                </div>
                            @endif

                        </form>
                    @else
                        <div class="alert alert-info">Please <a href="{{route('auth.login')}}">login</a> to continue</div>
                    @endif

                    <br><br>

                        <div class="row">
                            <div class="col-md-8 center-block">
                                @component('partials.v3.frame', ['type' => 'basic'])
                                    <h4>Secure payments</h4>
                                    <p>
                                        Before proceeding to the payment provider, you are required to login again.
                                        <br>
                                        Contact the community owner if you have any questions about your payments.
                                    </p>

                                @endcomponent
                            </div>
                        </div>
                </div>
            </div>
        </div>


    </div>

@endsection