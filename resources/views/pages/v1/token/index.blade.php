@extends('layouts.v2.banner', [
    'page' => [
        'title' => 'Tokens',
        'description' => 'With your order, you\'re helping the community!',
        'class' => 'token transaction'
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
            {{auth()->user()->displayTokenBalance()}}
        </h1>
    </div>
@stop

@section('page_content')

    <div class="container">
        <div class="row defaultcontent">

            <div class="col-md-12">
            @include('pages.v1.token.partials.list', [
                'transactions' => $transactions
            ])

            <div class="paginate">
                {!! $transactions->links() !!}
            </div>

            </div>

        </div>
    </div>

@stop