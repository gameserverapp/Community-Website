@extends('layouts.v2.banner', [
    'page' => [
        'title' => 'Supporter Tiers',
        'description' => 'With your order, you\'re helping the community!',
        'class' => 'supporter-tier buy'
    ],
    'banner' => [
        'size' => 'large',
        'text-only' => false,
        'vertical-align' => true,
    ]
])

@section('banner_content')

    <div class="col-md-8 text-only banner-container center-block">
        <h1>
            Supporter Tiers
            <i class="fa fa-trophy" aria-hidden="true"></i>
        </h1>

        <div class="row defaultcontent">

            @forelse( $packages as $tier )

                <div class="col-sm-6 col-md-4">
                    @include('pages.v1.partials.supporter-tier', [
                        'tier' => $tier
                    ])
                </div>

            @empty
                <div class="text-center">
                    <em>No tiers available</em>
                </div>
            @endforelse
        </div>
    </div>
@stop

@section('page_content')


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