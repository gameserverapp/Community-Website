<?php

namespace GameserverApp\Transformers;

use GameserverApp\Interfaces\ModelTransformerInterface;
use GameserverApp\Models\Message;
use GameserverApp\Models\News;
use GameserverApp\Models\Shop;
use GameserverApp\Models\Token;
use GameserverApp\Models\Transaction;
use GameserverApp\Models\User;

class ShopTransformer extends ModelTransformer implements ModelTransformerInterface
{

    public static function model(array $args)
    {
        return new Shop($args);
    }

    public static function transformableInput($args)
    {
        $data = [
            'id'          => $args->id,
            'name'        => $args->name,
            'description' => $args->description,
            'limit'       => $args->limit,
            'limit_days'  => $args->limit_days,
            'token_price' => $args->token_price,
            'cluster'     => $args->cluster,
            'image'       => $args->image
        ];

        if(isset($args->characters) and $args->characters) {
            $data['characters'] = CharacterTransformer::transformMultiple($args->characters);
        } else {
            $data['characters'] = false;
        }

        return $data;
    }
}