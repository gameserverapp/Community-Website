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
            'id'         => $args->id,
            'name'       => $args->persona->name,
            'steam_id'   => $args->persona->steam_id,
            'avatar'     => $args->persona->avatar,
            'online'     => $args->online,
            'banned'     => $args->banned,
            'donated'    => $args->donated,
            'created_at' => $args->meta->created_at,

            'role' => $args->role->id,
            'role_label' => $args->role->label
        ];
        
        if (isset($args->rules_accepted)) {
            $data['rules_accepted'] = $args->rules_accepted;
        }

        if (isset($args->notifications)) {
            $data['notifications'] = [
                'notify_webalert' => $args->notifications->notify_webalert,
                'notify_forum' => $args->notifications->notify_forum,
                'notify_message' => $args->notifications->notify_message,
                'email' => $args->notifications->email,
                'email_confirmed' => $args->notifications->email_confirmed
            ];
        }

        if (isset($args->twitch)) {
            $data['twitch'] = [
                'username' => $args->twitch->username,
                'streaming' => $args->twitch->streaming
            ];

            if (isset($args->twitch->oauth_redirect)) {
                $data['twitch']['oauth_redirect'] = $args->twitch->oauth_redirect;
            }
        }

        if (isset($args->discord)) {
            $data['discord'] = [
                'username' => $args->discord->username,
            ];

            if (isset($args->discord->oauth_redirect)) {
                $data['discord']['oauth_redirect'] = $args->discord->oauth_redirect;
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

        return $data;
    }
}