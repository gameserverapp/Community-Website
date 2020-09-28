<?php
namespace GameserverApp\Transformers;

use GameserverApp\Interfaces\ModelTransformerInterface;
use GameserverApp\Models\Character;
use GameserverApp\Models\User;

class CharacterTransformer extends ModelTransformer implements ModelTransformerInterface
{

    public static function model(array $args)
    {
        return new Character($args);
    }

    public static function transformableInput($args)
    {
        $data = [
            'id'           => $args->id,
            'name'         => utf8_decode($args->name),
            'level'        => $args->level,
            'gender'       => $args->gender,
            'hours_played' => $args->hours_played,
            'status'       => $args->status,
            'status_since' => $args->status_since,
            'streaming'    => $args->streaming,
            'created_at'   => $args->created_at
        ];

        if (isset($args->about)) {
            $data['about'] = $args->about->content;
            $data['about_image_url'] = $args->about->image_url;
        }

        if (isset($args->server)) {
            $data['server'] = ServerTransformer::transform($args->server);
        }

        if (isset($args->game)) {
            $data['game'] = GameTransformer::transform($args->game);
        }

        if (isset($args->groups)) {
            $data['groups'] = GroupTransformer::transformMultiple($args->groups);
        }

        if (isset($args->user)) {
            $data['user'] = UserTransformer::transform($args->user);
        }

        return $data;
    }
}