@extends('layouts.v2.banner', [
    'page' => [
        'title' => 'Supply history',
        'description' => '',
        'class' => 'supplies history'
    ],
    'banner' => [
        'size' => 'small',
        'text-only' => false,
        'vertical-align' => true,
        'navigation' => 'pages.v1.shop.partials.navigation'
    ]
])

@section('banner_content')

    @include('pages.v1.shop.partials.banner')
@stop

@section('page_content')

    <div class="container">
        <div class="row defaultcontent">
            @include('pages.v1.shop.partials.list', [
                'items' => $orders
            ])
            <div class="paginate">
                {!! $orders->links() !!}
            </div>
        </div>
    </div>

@stop