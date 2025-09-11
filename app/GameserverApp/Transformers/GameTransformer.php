<?php
namespace GameserverApp\Transformers;

use GameserverApp\Interfaces\ModelTransformerInterface;
use GameserverApp\Models\Game;
use GameserverApp\Models\Server;
use GameserverApp\Models\User;

class GameTransformer extends ModelTransformer implements ModelTransformerInterface
{

    public static function model(array $args)
    {
        return new Game($args);
    }

    public static function transformableInput($args)
    {
        $data = [
            'name'       => $args->name,
            'icon'        => $args->icon,

            'steam_client_id' => $args->steam->client_id,
            'steam_server_id' => $args->steam->server_id,

            'support_level' => $args->support->level,
            'support_gender' => $args->support->gender,
        ];

        return $data;
    }
}