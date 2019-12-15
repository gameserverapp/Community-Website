@extends('layouts.v2.banner', [
    'page' => [
        'title' => 'Tokens',
        'description' => 'With your order, you\'re helping the community!',
        'class' => 'token buy'
    ],
    'banner' => [
        'size' => 'small',
        'text-only' => false,
        'vertical-align' => true,
        'navigation' => 'pages.v1.token.partials.navigation'
    ]
])

@section('banner_content')

    <div class="col-md-8 text-only center-block">
        <h1>
            Token shop
        </h1>
    </div>
@stop

@section('page_content')
    <div class="container">
        <div class="row defaultcontent">


            @forelse( $packages as $package )

                <div class="col-sm-6 col-md-3">
                    @include('pages.v1.partials.token-pack', [
                        'package' => $package
                    ])
                </div>

            @empty
                <div class="text-center">
                    <em>No packs available</em>
                </div>
            @endforelse
        </div>
        {{--<div class="row">--}}
            {{--<div class="col-md-12 text-center">--}}
                {{--<a href="{{route('token.about')}}" class="btn champ inverted ghost dark small">What you can do with tokens &raquo;</a>--}}
            {{--</div>--}}
        {{--</div>--}}
    </div>


    <div class="container-fluid fulldark">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <!-- PayPal Logo --><table  border="0" cellpadding="10" cellspacing="0" align="center"><tr><td align="center"></td></tr><tr><td align="center"><a href="https://www.paypal.com/uk/webapps/mpp/paypal-popup" title="How PayPal Works" onclick="javascript:window.open('https://www.paypal.com/uk/webapps/mpp/paypal-popup','WIPaypal','toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=yes, width=1060, height=700'); return false;"><img src="https://www.paypalobjects.com/webstatic/mktg/Logo/AM_mc_vs_ms_ae_UK.png" width="200" border="0" alt="PayPal Acceptance Mark"></a></td></tr></table><!-- PayPal Logo -->
                </div>
            </div>
        </div>
    </div>

@stop