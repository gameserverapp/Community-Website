@extends('layouts.v3.default', [
    'page' => [
        'title' => translate('supporter_tiers', 'Supporter tiers'),
        'description' => 'Contribute to your community.',
        'class' => 'supporter-tier'
    ],

    'breadcrumbs' => [
        [
            'title' => translate('supporter_tiers', 'Supporter tiers')
        ]
    ]
])

@section('page_content')

<div class="row">

    <div class="col-md-4">

    </div>
    <div class="col-md-4 text-center title">
        <h1 class="main-title">{{translate('supporter_tiers', 'Supporter tiers')}}</h1>
    </div>
    <div class="col-md-4 coupon">
        <h4>Discount code:</h4>
        <form method="get">
            <div class="input-group">
                <input class="form-control" name="coupon" type="text" value="{{request('coupon', '')}}" placeholder="Enter your discount code">
                <span class="input-group-btn">
                    <button class="btn btn-default" type="submit">Apply</button>
                </span>
            </div>
        </form>

        <div class="hidden-desktop">
            <br>
        </div>
    </div>
</div>
<div class="row">

    @forelse( $packages as $tier )

        <div class="col-md-6 col-lg-4">
            @include('partials.v3.purchase-package', [
                'item' => $tier
            ])
        </div>

    @empty
        <div class="col-md-12">
            <div class="text-center">
                <em>No tiers available</em>
            </div>
        </div>
    @endforelse

</div>

<div class="row">
    <div class="paginate">
        {!! $packages->appends(Request::except('page'))->links() !!}
    </div>
</div>

@endsection