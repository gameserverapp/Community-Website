<?php

namespace GameserverApp\Models;

use GameserverApp\Api\Client;
use GameserverApp\Helpers\SiteHelper;
use GameserverApp\Interfaces\LinkableInterface;
use GameserverApp\Models\Forum\Thread;
use GameserverApp\Traits\Linkable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Auth\Authenticatable;

class User extends Model implements LinkableInterface, AuthenticatableContract, AuthorizableContract
{
    CONST ROLE_DISABLED = 0;
    CONST ROLE_USER = 1;
    CONST ROLE_VIP = 2;
    CONST ROLE_MODERATOR = 3;
    CONST ROLE_ADMIN = 4;
    CONST ROLE_SUPERADMIN = 5;

    use Linkable, Authenticatable, Authorizable;

    public function name($limit = false)
    {
        if ($limit) {
            return str_limit($this->name, $limit, '...');
        }

        return $this->name;
    }

    public function online()
    {
        return $this->online;
    }

    public function hasP2PSubscription()
    {
    }

    public function tokenBalance()
    {
        return $this->tokens;
    }

    public function hasEmailSetup()
    {
        return isset(auth()->user()->notifications['email']) and !empty(auth()->user()->notifications['email']);
    }

    public function emailConfirmed()
    {
        return $this->hasEmailSetup() and
            isset(auth()->user()->notifications['email_confirmed']) and
            auth()->user()->notifications['email_confirmed'];
    }

    public function displayTokenBalance()
    {
        if ($this->tokenBalance() == 1) {
            return '1 token';
        }

        return $this->tokenBalance() . ' tokens';
    }

    public function subscribedToThread(Thread $thread)
    {
        try {
            $client = app(Client::class);

            return $client->forumIsSubscribed($thread->id);
        } catch(\Exception $e) {
            return false;
        }
    }

    public function banned()
    {
        return $this->banned;
    }

    public function hasCharacters()
    {
        return isset($this->characters) and count($this->characters);
    }

    public function characterOnServer(Server $server)
    {
        if (! $this->hasCharacters()) {
            return false;
        }

        foreach ($this->characters as $character) {
            if (
                $character->hasServer() and
                $character->server->id == $server->id
            ) {
                return $character;
            }
        }

        return false;
    }

    public function isTwitchStreamer()
    {
        return ! is_null($this->twitch['username']);
    }

    public function twitchUsername()
    {
        return $this->twitch['username'];
    }

    public function twitchOAuthRedirect()
    {
        if(!isset($this->twitch['oauth_redirect'])) {
            return false;
        }

        return $this->twitch['oauth_redirect'];
    }


    public function isStreaming()
    {
        return $this->twitch['streaming'];
    }



    public function hasDiscordSetup()
    {
        return ! is_null($this->discord['username']);
    }

    public function discordUsername()
    {
        return $this->discord['username'];
    }

    public function discordOAuthRedirect()
    {
        if(!isset($this->discord['oauth_redirect'])) {
            return false;
        }

        return $this->discord['oauth_redirect'];
    }

    public function donated()
    {
        return $this->donated;
    }

    public function hasTribe($serverId = false)
    {
        if (! $this->hasCharacters()) {
            return false;
        }

        $characters = $this->characters->filter(function ($item) use ($serverId) {
            if ($serverId and $item->hasTribe() and $item->hasServer()) {
                return $item->tribe->server->id == $serverId;
            }

            return $item->hasTribe();
        });

        return $characters->count() > 0;
    }

    public function isTribeMember(Tribe $tribe)
    {
        if (! $this->hasCharacters()) {
            return false;
        }

        $characters = $this->characters->filter(function ($item) use ($tribe) {
            return $item->hasTribe($tribe);
        });

        return $characters->count() > 0;
    }

    public function displayRoleLabel()
    {
        $output = '';

        if ($this->role('Admin') or $this->role('Super Admin')) {
            $output .= '<span class="label label-admin">Admin</span>';
        }

        if ($this->donated()) {
            $output .= '<a href="' . route('token.buy') . '" class="label label-donor">Donor <3</a> &nbsp;';
        }

        return $output;
    }

    public function role($role)
    {
        if (is_integer($role)) {
            return $this->role >= $role;
        }

        return $this->role >= $this->availableRoles($role);
    }

    private function availableRoles($key = false)
    {
        $array = [
            'Disabled'    => self::ROLE_DISABLED,
            'User'        => self::ROLE_USER,
            'VIP'         => self::ROLE_VIP,
            'Moderator'   => self::ROLE_MODERATOR,
            'Admin'       => self::ROLE_ADMIN,
            'Super Admin' => self::ROLE_SUPERADMIN
        ];

        if ($key) {
            return $array[$key];
        }

        return $array;
    }

    public function unreadMessagesCount()
    {
        return $this->unread_messages;
    }

    public function lastCharacter()
    {
        if (! $this->characters->count()) {
            return false;
        }

        return $this->characters->first();
    }

    public function acceptedRules()
    {
        return $this->rules_accepted;
    }

    public function linkableTemplate($url, $options = [])
    {
        if (! isset($options['limit'])) {
            $options['limit'] = 99;
        }

        $output = [];

        if(!$this->hasCharacters()) {
            $options['disable_link'] = true;
        }

        $output[] = '<span class="linkwrapper" itemscope itemtype="http://schema.org/Person">';

        if (isset($options['disable_link'])) {
            $output[] = '<span class="accountlink-name">';
            $output[] = '<span itemprop="name">' . str_limit($this->name(14), $options['limit'], '...') . '</span>';
            $output[] = '</span>';
        } else {
            $output[] = '<a class="accountlink" href="' . $url . '" itemprop="url">';
            $output[] = '<span itemprop="name">' . str_limit($this->name(14), $options['limit'], '...') . '</span>';
            $output[] = '</a>';
        }

        if ($this->online()) {
            $output[] = $this->statusIndicator();
        }

        $output[] = '</span>';

        return implode('', $output);
    }
    
    private function statusIndicator($size = 'small')
    {
        if(!SiteHelper::featureEnabled('player_status') and !$this->isStreaming()) {
            return '';
        }

        $title = '';
        $class = [
            'aftername',
            'online'
        ];

        if ($this->isStreaming()) {
            $title = 'Streaming with character \'' . $this->name() . '\'';
            $class = [
                'aftername',
                'streaming'
            ];
        } else {
            if ($this->donated()) {
                $class[] = 'vip';
                $title .= 'Donor <3 | ';
            }

            $title .= 'Online with character \'' . $this->name() . '\'';
        }
//
        $class = $size . ' ' . implode(' ', $class);

        return '<span title="' . $title . '" class="status  ' . $class . '"></span>';
    }

    public function indexRoute()
    {
        // TODO: Implement indexRoute() method.
    }

    public function showRoute()
    {
        return route('user.show', $this->id);
    }
}