<?php

namespace GameserverApp\Transformers;

use GameserverApp\Interfaces\ModelTransformerInterface;
use GameserverApp\Models\Message;
use GameserverApp\Models\News;
use GameserverApp\Models\SupportTier;
use GameserverApp\Models\Token;
use GameserverApp\Models\User;

class SupportTierTransformer extends ModelTransformer implements ModelTransformerInterface
{

    public static function model(array $args)
    {
        return new SupportTier($args);
    }

    public static function transformableInput($args)
    {
        $data = [
            'id'                          => $args->id,
            'name'                        => $args->name,
            'description'                 => $args->description,
            'total_price'                 => $args->total_price,
            'discounted_price'            => $args->discounted_price,
            'discount_percentage'         => $args->discount_percentage,
            'discount_amount'             => $args->discount_amount,
            'personal_discount'           => $args->personal_discount,
            'currency'                    => $args->currency,
            'gateway'                     => $args->gateway ?? null,
            'type'                        => $args->type,
            'image'                       => $args->image,
            'limit'                       => $args->limit ?? false,
            'requires_discord'            => $args->requires_discord,
            'requires_character'          => $args->requires_character,
            'requires_gameserver'         => $args->requires_gameserver,
            'cluster'                     => $args->cluster,
            'gameserver'                  => $args->gameserver ?? false,
            'character_level_restriction' => $args->character_level_restriction ?? false,
            'order_url'                   => $args->order_url,
            'payment_providers'           => $args->psp
        ];

        if (
            isset($args->characters) and
            $args->characters
        ) {
            $data['characters'] = CharacterTransformer::transformMultiple($args->characters);
        } else {
            $data['characters'] = false;
        }

        if (
            isset($args->gameservers) and
            $args->gameservers
        ) {
            $data['gameservers'] = ServerTransformer::transformMultiple($args->gameservers);
        } else {
            $data['gameservers'] = false;
        }

        return $data;
    }
}