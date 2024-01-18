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
            'type'        => $args->type,
            'cluster'     => $args->cluster,
            'gameserver'  => $args->gameserver,
            'image'       => $args->image,
            'label'       => $args->label
        ];

        if (isset($args->limit)) {
            $data['limit'] = $args->limit;
        }

        if (isset($args->token_price)) {
            $data['token_price'] = $args->token_price;
        }

        if (isset($args->discount)) {
            $data['discount'] = $args->discount;
            $data['discounted_token_price'] = $args->discounted_token_price;
        }

        if (isset($args->requires_character)) {
            $data['requires_character'] = $args->requires_character;
        }

        if (isset($args->requires_gameserver)) {
            $data['requires_gameserver'] = $args->requires_gameserver;

            if (isset($args->gameservers) and $args->gameservers) {
                $data['gameservers'] = ServerTransformer::transformMultiple($args->gameservers);
            } else {
                $data['gameservers'] = false;
            }
        }

        if (isset($args->requires_discord)) {
            $data['requires_discord'] = $args->requires_discord;
        }

        if (isset($args->characters) and $args->characters) {
            $data['characters'] = CharacterTransformer::transformMultiple($args->characters);
        } else {
            $data['characters'] = false;
        }

        if (isset($args->children) and is_array($args->children) and count($args->children)) {
            $data['children'] = ShopTransformer::transformMultiple($args->children);
        }

        return $data;
    }
}