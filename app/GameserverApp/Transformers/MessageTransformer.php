<?php
namespace GameserverApp\Transformers;

use GameserverApp\Interfaces\ModelTransformerInterface;
use GameserverApp\Models\Message;
use GameserverApp\Models\User;

class MessageTransformer extends ModelTransformer implements ModelTransformerInterface
{

    public static function model(array $args)
    {
        return new Message($args);
    }

    public static function transformableInput($args)
    {
        $data = [
            'id'         => $args->id,
            'subject'       => $args->subject,
            'content'   => $args->content,
            'created_at' => $args->created_at
        ];

        if (isset($args->read)) {
            $data['read'] = $args->read;
        }

        if (isset($args->sender)) {
            $data['sender'] = UserTransformer::transform($args->sender);
        }

        if (isset($args->receiver)) {
            $data['receiver'] = UserTransformer::transform($args->receiver);
        }

        return $data;
    }
}