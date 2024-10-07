<?php
namespace GameserverApp\Transformers;

use GameserverApp\Interfaces\ModelTransformerInterface;
use GameserverApp\Models\Server;
use GameserverApp\Models\User;

class ServerTransformer extends ModelTransformer implements ModelTransformerInterface
{

    public static function model(array $args)
    {
        return new Server($args);
    }

    public static function transformableInput($args)
    {
        $data = [
            'id'         => $args->id,
            'name'       => $args->name,
            'p2p'        => $args->p2p,
            'twitch_sub_only' => $args->twitch_sub_only,
            'selfhosted' => $args->selfhosted,
            'background' => $args->background,
        ];

        if (isset($args->vote_sites)) {
            $data['vote_sites'] = $args->vote_sites;
        } else {
            $data['vote_sites'] = [];
        }

        if (isset($args->version)) {
            $data['version'] = $args->version;
        }

        if (isset($args->cluster_name)) {
            $data['cluster_name'] = $args->cluster_name;
        }

        if (isset($args->connect_address)) {
            $data['connect_address'] = $args->connect_address;
        }

        if (isset($args->steam_connect_address)) {
            $data['steam_connect_address'] = $args->steam_connect_address;
        }

        if (isset($args->slots)) {
            $data['slots'] = $args->slots;
        }

        if (isset($args->online_players)) {
            $data['online_players'] = $args->online_players;
        }

        if (isset($args->online)) {
            $data['online'] = $args->online;
        }

        if (isset($args->game)) {
            $data['game'] = GameTransformer::transform($args->game);
        }

        if (isset($args->update_at)) {
            $data['update_at'] = $args->update_at;
        }

        if (isset($args->shutdown_at)) {
            $data['shutdown_at'] = $args->shutdown_at;
        }

        if (isset($args->restart_at)) {
            $data['restart_at'] = $args->restart_at;
        }

        return $data;
    }
}