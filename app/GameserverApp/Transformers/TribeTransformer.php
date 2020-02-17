<?php
namespace GameserverApp\Transformers;

use GameserverApp\Interfaces\ModelTransformerInterface;
use GameserverApp\Models\Tribe;
use GameserverApp\Models\User;

class TribeTransformer extends ModelTransformer implements ModelTransformerInterface
{

    public static function model(array $args)
    {
        return new Tribe($args);
    }

    public static function transformableInput($args)
    {
        $data = [
            'id' => $args->id,
            'name' => $args->name,
            'about' => $args->about,
            'motd' => $args->motd,
            'online' => $args->online
        ];

        if(isset($args->members)) {
            $data['members'] = CharacterTransformer::transformMultiple($args->members);
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