<?php

namespace GameserverApp\Models;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use GameserverApp\Interfaces\LinkableInterface;
use GameserverApp\Traits\Linkable;

class Tribe extends Model implements LinkableInterface
{
    use Linkable;

    public function name($limit = false)
    {
        if ($limit) {
            return str_limit($this->name, $limit, '');
        }

        return $this->name;
    }

    public function online()
    {
        $this->online;
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
        if($this->hasMembers()) {
            return $this->members->where('user.id', $user->id)->where('tribe_admin', true)->count() > 0;
        }

        return false;
    }

    public function isOwner(User $user)
    {
        if($this->hasMembers()) {
            return $this->members->where('user.id', $user->id)->where('tribe_owner', true)->count() > 0;
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
        if(!$this->hasMembers()) {
            return 0;
        }

        return $this->members->count();
    }

    public function bannerBackground($max_count = 390)
    {
        $cacheKey = md5($this->id);

        if(Cache::has($cacheKey)) {
            return Cache::get($cacheKey);
        }

        $members = [];
        $output = '';

        if (! $this->hasMembers()) {
            return;
        }

        foreach ($this->members as $character) {
            $members[] = $character->user->avatar;
        }

        $max_rand = count($members) - 1;

        $output = '<div class="imgcontainer">';

        for ($i = 0; $i <= $max_count; $i++) {
            $output .= '<div class="memberimage">' .
                '<img src="' . $members[rand(0, $max_rand)] . '">' .
                '</div>';
        }

        $output .= '</div>';

        Cache::put($cacheKey, $output, config('gameserverapp.cache.tribe_background'));

        return $output;
    }

    public function hasMembers()
    {
        return isset($this->members) and count($this->members);
    }

    public function hasOwner()
    {
        return isset($this->owner_id);
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
        return route('tribe.show', $this->id);
    }

    public static function createFromApiCollection(Collection $collection)
    {
        return $collection->map(function ($item) {
            return self::createFromApi($item);
        });
    }
}