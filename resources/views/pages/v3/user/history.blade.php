<?php
use GameserverApp\Models\Order;
?>

@extends('layouts.v3.default', [
    'page' => [
        'title' => translate('reward_shop_history', 'Reward shop history'),
        'description' => 'Check out your reward shop history',
        'class' => 'user-single',
        'attributes' => ''
    ],
])

@section('page_content')
    @include('pages.v3.user._header')

    <div class="row">
        <div class="col-md-10 center-block">

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