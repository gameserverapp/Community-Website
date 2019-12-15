<?php
use GameserverApp\Models\Order;
?>
@include('partials.frame.simple-top')
<div class="panel panel-default">
    <!-- Default panel contents -->
    <div class="panel-heading">
        Items
    </div>

    <table class="table">
        <thead>
        <tr>
            <th>Status</th>
            <th>Package</th>
            <th>Order #</th>
        </tr>
        </thead>
        <tbody>

        @foreach($items as $item)
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
</div>
@include('partials.frame.simple-bottom')