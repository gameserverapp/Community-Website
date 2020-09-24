<?php
use GameserverApp\Models\Order;
?>

@extends('layouts.v3.default', [
    'page' => [
        'title' => translate('reward_shop_history', 'Reward shop history'),
        'description' => 'Check out your reward shop history',
        'class' => 'package-single',
        'attributes' => ''
    ],

    'breadcrumbs' => [
        [
            'title' => translate('reward_shop', 'Reward shop'),
            'route' => route('shop.index')
        ],
        [
            'title' => translate('history', 'History')
        ],
    ]
])

@section('page_content')

    <div class="row">

        <div class="col-md-12 text-center title">
            <h1>{{translate('reward_shop_history', 'Reward shop history')}}</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8 center-block">

            @component('partials.v3.frame', ['class' => 'no-padding'])
                <table class="table">
                    <thead>
                    <tr>
                        <th>Status</th>
                        <th>Package</th>
                        <th>Order #</th>
                    </tr>
                    </thead>
                    <tbody>

                    @foreach($orders as $item)
                        <tr>
                            <td>
                                <?php
                                switch( $item->status() )
                                {
                                    case Order::STATUS_PROCESSING:
                                        print '<div class="label label-default">Processing</div>';
                                        break;

                                    case Order::STATUS_FULL_INVENTORY:
                                        print '<div class="label label-danger">Character / Dino in inventory</div>';
                                        break;

                                    case Order::STATUS_DELIVERED:
                                        print '<div class="label label-warning">Delivered</div>';
                                        break;

                                    case Order::STATUS_PICKEDUP:
                                        print '<div class="label label-success">Picked up</div>';
                                        break;
                                }
                                ?>
                            </td>
                            <td>{{$item->name()}}</td>
                            <td>{{$item->id}}</td>
                        </tr>
                    @endforeach

                    </tbody>
                </table>
            @endcomponent

            <div class="paginate">
                {!! $orders->links() !!}
            </div>
        </div>

        </div>
    </div>

@stop