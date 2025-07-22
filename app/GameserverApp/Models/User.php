<?php

namespace GameserverApp\Models;

use App\GameserverApp\Traits\Socials;
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
    use Linkable, Authenticatable, Authorizable, Socials;

    /**
     * Disable mass assignment protection since we're only using API data
     */
    protected $guarded = [];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'created_at',
        'updated_at',
        // Add any other date fields your API returns
    ];

    /**
     * Get the name of the unique identifier for the user.
     *
     * @return string
     */
    public function getAuthIdentifierName()
    {
        return 'id';
    }

    /**
     * Get the unique identifier for the user.
     *
     * @return mixed
     */
    public function getAuthIdentifier()
    {
        return $this->id;
    }

    public function name($limit = false)
    {
        if ($limit) {
            return str_limit($this->name, $limit, '...');
        }

        return $this->name;
    }

    public function serviceId()
    {
        return $this->service_id;
    }

    public function serviceType()
    {
        return $this->service_type;
    }

    public function online()
    {
        return $this->online;
    }

    public function allUserIds()
    {
        $output = [
            $this->id
        ];
        
        if(isset($this->sub_users)) {
            $output = array_merge($output, $this->sub_users->pluck('id')->toArray());
        }

        return $output;
    }

    public function hasP2PSubscription()
    {
    }

    public function hoursPlayed()
    {
        return number_format($this->hours_played, 2);
    }

    public function avatar()
    {
        if(is_null($this->avatar)) {
            return config('gameserverapp.connection.oauth_base_url') . 'img/default-group-logo.png';
        }

        return $this->avatar;
    }

    public function votes()
    {
        return $this->votes;
    }

    public function donatedAmount()
    {
        return $this->donated_amount;
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

        $characters = $this->characters->filter(function($character) use ($server) {
            return $character->hasServer() and $character->server->id == $server->id;
        });

        if($characters->count()) {
            return $characters->first();
        }

        return false;
    }


    public function donated()
    {
        return $this->donated;
    }

    public function hasGroup($server = false)
    {
        if (! $this->hasCharacters()) {
            return false;
        }

        if(!$server) {
            $characters = $this->characters->filter(function ($item) {
                return $item->hasGroup();
            });
        } else {
            $characters = $this->characters->filter(function ($item) use ($server) {
                return $item->groupForServer($server);
            });
        }

        return $characters->count() > 0;
    }

    public function isGroupMember(Group $group)
    {
        if (! $this->hasCharacters()) {
            return false;
        }

        $characters = $this->characters->filter(function ($item) use ($group) {
            return $item->isGroupMember($group);
        });

        return $characters->count() > 0;
    }

    public function hasPermission($key)
    {
        if(
            !isset($this->permissions) or
            !isset($this->permissions->$key)
        ) {
            return false;
        }

        return $this->permissions->$key;
    }

    public function unreadMessagesCount()
    {
        return $this->unread_messages;
    }

    public function canSendTokens()
    {
        return SiteHelper::featureEnabled('send_tokens');
    }

    public function canSendMessage()
    {
        if(!SiteHelper::featureEnabled('messages_send')) {
            return $this->hasPermission('send_message');
        }

        if($this->banned()) {
            return false;
        }

        return true;
    }

    public function lastCharacter()
    {
        if (! $this->characters->count()) {
            return false;
        }

        return $this->characters->first();
    }

    public function hasRuleGates()
    {
        return isset($this->rule_gates) and count($this->rule_gates);
    }

    public function ruleGateUrls()
    {
        if(!auth()->check()) {
            return [];
        }

        if(isset($this->ruleGateUrls)) {
            return $this->ruleGateUrls;
        }

        $output = [];

        foreach(auth()->user()->ruleGates() as $ruleGate) {
            $output[] = $ruleGate->route;
        }

        $this->ruleGateUrls = $output;

        return $output;
    }

    public function ruleGates()
    {
        return $this->rule_gates;
    }

    public function linkableTemplate($url, $options = [])
    {
        if (! isset($options['limit'])) {
            $options['limit'] = 99;
        }

        $output = [];

//        if(!$this->hasCharacters()) {
//            $options['disable_link'] = true;
//        }

        $output[] = '<span class="linkwrapper" itemscope itemtype="http://schema.org/Person">';

        if (isset($options['disable_link']) or !SiteHelper::featureEnabled('user_page')) {
            $output[] = '<span class="accountlink-name">';
            $output[] = '<span itemprop="name">' . $this->name($options['limit']) . '</span>';
            $output[] = '</span>';
        } else {
            $output[] = '<a class="accountlink" href="' . $url . '" itemprop="url">';
            $output[] = '<span itemprop="name">' . $this->name($options['limit']) . '</span>';
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
        if(!SiteHelper::featureEnabled('player_status')) {
            return '';
        }

        $title = '';
        $class = [
            'aftername',
            'online'
        ];

        if ($this->donated()) {
            $class[] = 'vip';
            $title .= 'Supporter <3 | ';
        }

        $title .= 'Online with character \'' . $this->name() . '\'';

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