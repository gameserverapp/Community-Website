<?php
namespace GameserverApp\Transformers;

use GameserverApp\Interfaces\ModelTransformerInterface;
use GameserverApp\Models\Delivery;
use GameserverApp\Models\Message;
use GameserverApp\Models\News;
use GameserverApp\Models\Order;
use GameserverApp\Models\Shop;
use GameserverApp\Models\Token;
use GameserverApp\Models\Transaction;
use GameserverApp\Models\User;

class DeliveryTransformer extends ModelTransformer implements ModelTransformerInterface
{

    public static function model(array $args)
    {
        return new Delivery($args);
    }

    public static function transformableInput($args)
    {
        $data = [
            'id'          => $args->id,
            'name'        => $args->name,
            'transaction_id' => $args->transaction_id,
            'status'       => $args->status,
            'created_at'  => $args->created_at
        ];

        return $data;
    }
}