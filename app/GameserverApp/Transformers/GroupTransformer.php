<?php
namespace GameserverApp\Transformers;

use GameserverApp\Interfaces\ModelTransformerInterface;
use GameserverApp\Models\Group;
use GameserverApp\Models\User;

class GroupTransformer extends ModelTransformer implements ModelTransformerInterface
{

    public static function model(array $args)
    {
        return new Group($args);
    }

    public static function transformableInput($args)
    {
        $data = [
            'id' => $args->id,
            'name' => $args->name,
            'about' => $args->about,
            'motd' => $args->motd,
            'online' => $args->online,
            'member_count' => $args->member_count,
            'created_at' => $args->created_at,
            'discord_connected' => $args->discord_connected
        ];

        if(isset($args->members)) {
            $data['members'] = CharacterTransformer::transformMultiple($args->members);
        } else {
            $data['members'] = [];
        }

        if(isset($args->images)) {

            if (isset($args->images->logo)) {
                $data['images']['logo'] = $args->images->logo;
            }

            if (isset($args->images->background)) {
                $data['images']['background'] = $args->images->background;
            }
        }

        if(isset($args->discord)) {

            $data['discord'] = [
                'name' => $args->discord->name,
            ];

            if (isset($args->discord->oauth_redirect)) {
                $data['discord']['oauth_redirect'] = $args->discord->oauth_redirect;
            }

            if (isset($args->discord->available_channels)) {
                $data['discord']['available_channels'] = $args->discord->available_channels;
            }

            if (isset($args->discord->channel)) {
                $data['discord']['channel'] = $args->discord->channel;
            }
        }

        if(isset($args->owners)) {
            $data['owners'] = $args->owners;
        }

        if(isset($args->admins)) {
            $data['admins'] = $args->admins;
        }

        if(isset($args->server)) {
            $data['server'] = ServerTransformer::transform($args->server);
        }

        if(isset($args->game)) {
            $data['game'] = GameTransformer::transform($args->game);
        }

        if(isset($args->cluster)) {
            $data['cluster'] = ClusterTransformer::transform($args->cluster);
        }

        return $data;
    }
}