<?php

namespace GameserverApp\Models;

use Carbon\Carbon;
use GameserverApp\Helpers\SiteHelper;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use GameserverApp\Interfaces\LinkableInterface;
use GameserverApp\Traits\Linkable;

class Group extends Model implements LinkableInterface
{
    use Linkable;

    public function name($limit = false)
    {
        if ($limit) {
            return str_limit($this->name, $limit, '');
        }

        return $this->name;
    }

    public function about()
    {
        return $this->about;
    }

    public function motd()
    {
        return $this->motd;
    }

    public function online()
    {
        $this->online;
    }

    public function memberCount()
    {
        return $this->member_count;
    }

    public function foundedDate()
    {
        return Carbon::parse($this->created_at)->format('M. Y');
    }

    public function discordSetup()
    {
        return !is_null($this->discordServerName());
    }

    public function discordChannelSetup()
    {
        return $this->discord_connected;
    }

    public function discordServerName()
    {
        if(!isset($this->discord)) {
            return null;
        }

        return $this->discord['name'];
    }

    public function discordOAuthRedirectUrl()
    {
        if(!isset($this->discord['oauth_redirect'])) {
            return null;
        }

        return $this->discord['oauth_redirect'];
    }

    public function hasServer()
    {
        return isset($this->server) and $this->server instanceof Server;
    }

    public function hasCluster()
    {
        return isset($this->cluster) and $this->cluster instanceof Cluster;
    }

    public function countOnlineMembers()
    {
        return $this->onlineMembers()->count();
    }

    public function isAdmin(User $user)
    {
        if($this->hasAdmins()) {
            return in_array($user->id, $this->admins);
        }

        return false;
    }

    public function isOwner(User $user)
    {
        if($this->hasOwners()) {
            return in_array($user->id, $this->owners);
        }

        return false;
    }

    public function onlineMembers()
    {
        if(!$this->hasMembers()) {
            return collect([]);
        }

        return $this->members->filter(function($item) {
            return $item->online();
        });
    }

    public function countAllMembers()
    {
        return $this->memberCount();
    }

    public function logo()
    {
        if(
            isset($this->images['logo']) and
            !is_null($this->images['logo'])
        ) {
            return $this->images['logo'];
        }

        return 'https://dash.gameserverapp.com/img/default-group-logo.png';
    }

    public function backgroundImage()
    {
        if(
            isset($this->images['background']) and
            !is_null($this->images['background']) and
            SiteHelper::featureEnabled('tribe_image_upload')
        ) {
            return $this->images['background'];
        }

        return SiteHelper::background();
    }

    public function hasMembers()
    {
        return isset($this->members) and count($this->members);
    }

    public function hasOwners()
    {
        return isset($this->owners) and count($this->owners);
    }

    public function hasAdmins()
    {
        return isset($this->admins) and count($this->admins);
    }

    public function hasGame()
    {
        return isset($this->game);
    }

    public function linkableTemplate($url, $options = [])
    {
        if (! isset($options['limit'])) {
            $options['limit'] = 99;
        }

        $output = [];

        $output[] = '<span class="linkwrapper" itemscope itemtype="http://schema.org/Organization">';

        if (isset($options['disable_link'])) {
            $output[] = '<span class="tribelink-name">';
            $output[] = '<span itemprop="name">' . str_limit($this->name(), $options['limit'], '...') . '</span>';
            $output[] = '</span>';
        } else {
            $output[] = '<a class="tribelink" href="' . $url . '" itemprop="url">';
            $output[] = '<span itemprop="name">' . str_limit($this->name(), $options['limit'], '...') . '</span>';
            $output[] = '</a>';
        }

        if ($this->online()) {
            $output[] = $this->statusIndicator();
        }

        $output[] = '</span>';

        return implode('', $output);
    }

    public function indexRoute()
    {
        // TODO: Implement indexRoute() method.
    }

    public function showRoute()
    {
        return route('group.show', $this->id);
    }

    public static function createFromApiCollection(Collection $collection)
    {
        return $collection->map(function ($item) {
            return self::createFromApi($item);
        });
    }
}