<?php

namespace GameserverApp\Transformers;

use GameserverApp\Interfaces\ModelTransformerInterface;
use GameserverApp\Models\Message;
use GameserverApp\Models\News;
use GameserverApp\Models\Sale;
use GameserverApp\Models\Token;
use GameserverApp\Models\Transaction;
use GameserverApp\Models\User;

class SaleTransformer extends ModelTransformer implements ModelTransformerInterface
{

    public static function model(array $args)
    {
        return new Sale($args);
    }

    public static function transformableInput($args)
    {
        $data = [
            'id'       => $args->id,
            'currency' => $args->currency,
            'amount'   => $args->amount,
            'date'     => $args->date,
            'user'     => UserTransformer::transform($args->user),
        ];

        return $data;
    }
}