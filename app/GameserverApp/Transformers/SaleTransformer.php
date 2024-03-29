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
            'discount' => $args->discount
        ];

        if(isset($args->user)) {
           $data['user'] = UserTransformer::transform($args->user);
        }

        if(isset($args->relatable)) {
            $data['relatable'] = SupportTierTransformer::transform($args->relatable);
        }

        if(isset($args->download_invoice_link)) {
            $data['invoice_link'] = $args->download_invoice_link;
        }

        if(isset($args->is_subscription)) {
            $data['subscription_sale'] = true;
        } else {
            $data['subscription_sale'] = false;
        }

        return $data;
    }
}