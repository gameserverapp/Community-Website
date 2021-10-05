<?php
use GameserverApp\Models\Delivery;
?>

@extends('layouts.v3.default', [
    'page' => [
        'title' => translate('deliveries', 'Deliveries'),
        'description' => 'Delivery history',
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

                    @forelse($orders as $item)
                        <tr>
                            <td>
                                <?php
                                switch( $item->status() )
                                {
                                    case Delivery::STATUS_CREATED:
                                    case Delivery::STATUS_IN_PROGRESS:
                                        print '<div class="label label-default">Processing</div>';
                                        break;

                                    case Delivery::STATUS_SUCCESS:
                                        print '<div class="label label-success">Delivered</div>';
                                        break;

                                    case Delivery::STATUS_WAITING_PLAYER_COME_ONLINE:
                                        print '<div class="label label-warning">Waiting for player</div>';
                                        break;

                                    case Delivery::STATUS_FULL_INVENTORY:
                                        print '<div class="label label-warning">Character / Dino in inventory</div>';
                                        break;

                                    case Delivery::STATUS_UNDELIVERABLE:
                                        print '<div class="label label-danger">Undeliverable</div>';
                                        break;

                                    case Delivery::STATUS_ISSUE:
                                        print '<div class="label label-danger">Error</div>';
                                        break;
                                }
                                ?>
                            </td>
                            <td>{{$item->name()}}</td>
                            <td>{{$item->id}}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3"><em>No deliveries yet.</em></td>
                        </tr>
                    @endforelse

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