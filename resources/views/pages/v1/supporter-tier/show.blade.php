@extends('layouts.v2.banner', [
    'page' => [
        'title' => $package->name(),
        'description' => 'Your ordered items are delivered in real-time. Order now!',
        'class' => 'supporter-tier single'
    ],
    'banner' => [
        'size' => 'small',
        'text-only' => false,
        'vertical-align' => true
    ]
])

@section('banner_content')

    <div class="col-md-8 text-only center-block">
        <h1>
            Order: <span>{{$package->name()}}</span>
        </h1>
    </div>
@stop

@section('page_content')

    <div class="container">
        <div class="row defaultcontent">

            <div class="col-md-8 center-block">
                <div class="row">

                    <div class="col-md-2">
                        <img height="80" src="{{$package->image()}}"
                             alt="{{$package->image()}}">
                    </div>
                    <div class="col-md-8">

                        @if(auth()->check())
                            @if($package->requiresDiscordSetup() and !auth()->user()->hasDiscordSetup())
                                <div class="alert alert-danger">
                                    You need to <a href="{{route('user.settings', auth()->user()->id)}}">setup your Discord</a> to receive this package.
                                </div>
                            @endif
                        @endif

                        @if($package->cluster)
                            <div class="alert alert-warning">
                                <span>
                                    <i class="fa fa-exclamation-triangle" aria-hidden="true"></i>
                                    Only deliverable on the <strong>{{$package->cluster}}</strong> cluster!
                                </span>
                            </div>
                        @endif

                        <h2>
                            Your order: {{$package->name()}}
                        </h2>

                        @include('partials.frame.simple-top')
                        <ul class="list-group">
                            <li class="list-group-item">
                                Order contents: {!! Markdown::convertToHtml($package->description()) !!}
                            </li>
                            <li class="list-group-item">
                                Total price: <strong>{{$package->displayTotalPrice()}}</strong>
                            </li>
                        </ul>
                        @include('partials.frame.simple-bottom')

                        {!! Form::open(['url'=>$package->orderUrl(), 'method' => 'get']) !!}

                        <div class="btnwrap">
                            {!! Form::submit('Order with PayPal &raquo;', array('class' => 'btn champ small')) !!}
                        </div>

                        {!! Form::close() !!}

                    </div>
                </div>
            </div>

            <br><br>
            <br><br>
            <div class="col-md-6 center-block">

                <h4>Customer support</h4>
                <p>
                    You can easily contact the merchant via your PayPal transaction overview. There you can find a "contact merchant" form.
                </p>
                <hr>

                <div class="row">
                    <div class="col-md-6">
                        <h4>Security</h4>
                        <p>
                            Before proceeding to PayPal, your STEAM identity will be verified.
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

            </div>


        </div>
    </div>

@stop