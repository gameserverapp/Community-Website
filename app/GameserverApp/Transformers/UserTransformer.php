<?php

namespace GameserverApp\Transformers;

use GameserverApp\Interfaces\ModelTransformerInterface;
use GameserverApp\Models\User;

class UserTransformer extends ModelTransformer implements ModelTransformerInterface
{

    public static function model(array $args)
    {
        return new User($args);
    }

    public static function transformableInput($args)
    {
        $data = [
            'id'           => $args->id,
            'name'         => utf8_decode($args->persona->name),
            'service_id'   => $args->persona->service_id,
            'service_type' => $args->persona->service_type,
            'avatar'       => $args->persona->avatar,
        ];

        if(isset($args->online)) {
            $data['online'] = $args->online;
        }

        if(isset($args->banned)) {
            $data['banned'] = $args->banned;
        }

        if(isset($args->donated)) {
            $data['donated'] = $args->donated;
        }

        if(isset($args->rule_gates)) {
            $data['rule_gates'] = $args->rule_gates;
        }

        if(isset($args->meta->created_at)) {
            $data['created_at'] = $args->meta->created_at;
        }

        if (isset($args->meta->total_hours_played)) {
            $data['hours_played'] = $args->meta->total_hours_played;
        }

        if (isset($args->permissions)) {
            $data['permissions'] = $args->permissions;
        }

        if (isset($args->notifications)) {
            $data['notifications'] = [
                'notify_webalert' => $args->notifications->notify_webalert,
                'notify_forum'    => $args->notifications->notify_forum,
                'notify_message'  => $args->notifications->notify_message,
                'email'           => $args->notifications->email,
                'email_confirmed' => $args->notifications->email_confirmed
            ];
        }

        if (isset($args->sub_users)) {
            $data['sub_users'] = self::transformMultiple($args->sub_users);
        }

        if (isset($args->connect_users)) {
            $data['connect_users'] = $args->connect_users;
        }

        if (isset($args->sub_user_links)) {
            $data['sub_user_links'] = $args->sub_user_links;
        }

        if (isset($args->social)) {
            if (isset($args->social->twitch->username)) {
                $data['twitch'] = [
                    'username'  => $args->social->twitch->username,
                    'icon'      => $args->social->twitch->icon
                ];
            }

            if (isset($args->social->discord->username)) {
                $data['discord'] = [
                    'username' => $args->social->discord->username,
                    'icon'     => $args->social->discord->icon
                ];
            }
        }

        if (isset($args->unread_messages)) {
            $data['unread_messages'] = $args->unread_messages;
        }

        if (isset($args->characters)) {
            $data['characters'] = CharacterTransformer::transformMultiple($args->characters);
        }

        if (isset($args->tokens)) {
            $data['tokens'] = $args->tokens;
        }

        if (isset($args->votes)) {
            $data['votes'] = $args->votes;
        }

        if (isset($args->donated_amount)) {
            $data['donated_amount'] = $args->donated_amount;
        }

        return $data;
    }
}