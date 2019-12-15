<?php
namespace GameserverApp\Transformers;

use GameserverApp\Interfaces\ModelTransformerInterface;
use GameserverApp\Models\Message;
use GameserverApp\Models\News;
use GameserverApp\Models\Token;
use GameserverApp\Models\Transaction;
use GameserverApp\Models\User;

class TransactionTransformer extends ModelTransformer implements ModelTransformerInterface
{

    public static function model(array $args)
    {
        return new Transaction($args);
    }

    public static function transformableInput($args)
    {
        $data = [
            'id'                => $args->id,
            'receiver'          => UserTransformer::transform($args->receiver),
            'sender'            => empty($args->sender) ? null : UserTransformer::transform($args->sender),
            'transaction_value' => $args->transaction_value,
            'transaction_type'  => $args->transaction_type,
            'description'       => $args->description,
            'created_at'        => $args->created_at
        ];

        return $data;
    }
}