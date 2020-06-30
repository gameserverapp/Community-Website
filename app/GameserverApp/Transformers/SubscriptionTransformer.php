<?php

namespace GameserverApp\Transformers;

use GameserverApp\Interfaces\ModelTransformerInterface;
use GameserverApp\Models\Message;
use GameserverApp\Models\News;
use GameserverApp\Models\Subscription;
use GameserverApp\Models\Token;
use GameserverApp\Models\Transaction;
use GameserverApp\Models\User;

class SubscriptionTransformer extends ModelTransformer implements ModelTransformerInterface
{

    public static function model(array $args)
    {
        return new Subscription($args);
    }

    public static function transformableInput($args)
    {
        $data = [
            'id'                 => $args->id,
            'currency'           => $args->currency,
            'amount'             => $args->amount,
            'requires_character' => $args->requires_character,
            'character'          => $args->character ? CharacterTransformer::transform($args->character) : false,
            'status'             => $args->status,
            'created_at'         => $args->created_at,
            'expires_at'         => $args->expires_at
        ];

        if (isset($args->relatable)) {

            if (
                isset($args->relatable->id) and
                isset($args->relatable->route)
            ) {
                $data['relatable_url'] = route($args->relatable->route, $args->relatable->id);
            }

            if (isset($args->relatable->name)) {
                $data['relatable_name'] = $args->relatable->name;
            }

            if (
                isset($args->relatable->available_characters) and
                $args->relatable->available_characters
            ) {
                $data['available_characters'] = CharacterTransformer::transformMultiple($args->relatable->available_characters);
            }
        }

        return $data;
    }
}