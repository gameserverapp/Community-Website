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

    <div class="col-md-12 text-center title">
        <h1>{{translate('supporter_tiers', 'Supporter tiers')}}</h1>
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

    <div class="paginate">
        {!! $packages->links() !!}
    </div>

</div>

@stop