<?php
use GameserverApp\Helpers\SiteHelper;
?>

@extends('layouts.v2.banner', [
    'page' => [
        'title' => 'Shop',
        'description' => 'Your orders are delivered in real-time! Pick it up at the nearest Supply Crate or Obelisk!',
        'class' => 'supplies buy'
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
            <div class="col-md-12">

                @forelse( $packs as $pack )

                    <div class="col-sm-6 col-md-3">
                        @include('pages.v1.partials.shop-pack', [
                            'pack' => $pack
                        ])
                    </div>
                @empty
                    <em>No items found</em>
                @endforelse
            </div>

            <div class="col-md-12">
                <div class="paginate">
                    {!! $packs->links() !!}
                </div>
            </div>
        </div>
    </div>

{{--
    <div class="container-fluid fulldark">
        <div class="container ">
            <div class="row  display-table">
                <div class="col-sm-6 table-cell">
                    <img src="/img/pickup/message-received.png" width="500">
                </div>

                <div class="col-sm-6 table-cell">
                    <h2>How to pick up your order?</h2>
                    <p>
                        When you finished your order, Champ (the Champion robot) will try to deliver your order as quickly as possible. This usually takes less then 1 minute.
                    </p>
                    <p>
                        <a class="btn champ" href="#">Pick up your order &raquo;</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
--}}
@stop