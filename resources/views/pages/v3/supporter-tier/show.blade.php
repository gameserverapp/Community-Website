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
                                            <button class="btn btn-default" type="submit">Apply</button>
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
                                    'class' => 'btn-theme-rock'
                                ])
                            </div>

                        </form>
                    @else
                        <div class="alert alert-info">Please <a href="{{route('auth.login')}}">login</a> to continue</div>
                    @endif

                    <br><br>

                        <div class="row">
                            <div class="col-md-8 center-block">
                                @component('partials.v3.frame', ['type' => 'basic'])

                                    @if($package->isStripe())

                                        <h4>Payments via Stripe</h4>
                                        <p>
                                            We use Stripe to process payments.
                                        </p>
                                        <p>
                                            Before proceeding to Stripe, your Steam identity will be verified.
                                        </p>
                                    @elseif($package->isPayPal())

                                        <h4>Customer support</h4>
                                        <p>
                                            You can easily contact the merchant via your PayPal transaction overview. There you can find a "contact merchant" form.
                                        </p>
                                        <hr>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <h4>Security</h4>
                                                <p>
                                                    Before proceeding to PayPal, your Steam identity will be verified.
                                                </p>
                                            </div>
                                            <div class="col-md-6">
                                                <!-- PayPal Logo -->
                                                <br>
                                                <table style="margin-top:0px; margin-bottom:-20px;" border="0" cellpadding="10" cellspacing="0"
                                                       align="center">
                                                    <tr>
                                                        <td align="center"></td>
                                                    </tr>
                                                    <tr>
                                                        <td align="center"><a href="https://www.paypal.com/uk/webapps/mpp/paypal-popup"
                                                                              title="How PayPal Works"
                                                                              onclick="javascript:window.open('https://www.paypal.com/uk/webapps/mpp/paypal-popup','WIPaypal','toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=yes, width=1060, height=700'); return false;"><img
                                                                        src="https://www.paypalobjects.com/webstatic/mktg/Logo/AM_mc_vs_ms_ae_UK.png"
                                                                        width="200" border="0" alt="PayPal Acceptance Mark"></a></td>
                                                    </tr>
                                                </table>
                                                <!-- PayPal Logo -->
                                            </div>
                                        </div>
                                    @endif

                                @endcomponent
                            </div>
                        </div>
                </div>
            </div>
        </div>


    </div>

@endsection