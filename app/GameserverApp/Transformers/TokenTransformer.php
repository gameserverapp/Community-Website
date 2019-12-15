<?php
namespace GameserverApp\Transformers;

use GameserverApp\Interfaces\ModelTransformerInterface;
use GameserverApp\Models\Message;
use GameserverApp\Models\News;
use GameserverApp\Models\Token;
use GameserverApp\Models\User;

class TokenTransformer extends ModelTransformer implements ModelTransformerInterface
{

    public static function model(array $args)
    {
        return new Token($args);
    }

    public static function transformableInput($args)
    {
        $data = [
            'id'          => $args->id,
            'name'        => $args->name,
            'quantity'    => $args->quantity,
            'total_price' => $args->total_price,
            'token_price' => $args->token_price,
            'currency'    => $args->currency,
            'image'       => $args->image,
            'order_url'   => $args->order_url
        ];

        return $data;
    }
}