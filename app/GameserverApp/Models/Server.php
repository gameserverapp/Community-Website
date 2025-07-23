<?php

namespace GameserverApp\Models;

use Illuminate\Support\Collection;
use GameserverApp\Interfaces\LinkableInterface;
use GameserverApp\Traits\Linkable;

class Server extends Model implements LinkableInterface
{
    use Linkable;

    public function name($limit = 16)
    {
        return str_limit($this->name, $limit, '');
    }

    public function connectAddress()
    {
        return isset($this->connect_address) ? $this->connect_address : null;
    }

    public function directConnectAddress()
    {
        if(isset($this->steam_connect_address)) {
            return $this->steam_connect_address;
        }

        return $this->connectAddress();
    }

    public function slots()
    {
        if(!isset($this->slots)) {
            return false;
        }

        return $this->slots;
    }

    public function onlinePlayers()
    {
        if(!isset($this->online_players)) {
            return false;
        }

        return $this->online_players;
    }

    public function isScheduledForUpdate()
    {
        return isset($this->update_at);
    }

    public function isScheduledForShutdown()
    {
        return isset($this->shutdown_at);
    }

    public function isScheduledForRestart()
    {
        return isset($this->restart_at);
    }

    public function isScheduled()
    {
        return isset($this->update_at) or isset($this->shutdown_at) or isset($this->restart_at);
    }

    public function displayLabel()
    {
        return '<div class="label label-theme alternative server">' . $this->name() . '</div>';
    }

    public function online()
    {
        return isset($this->online) ? $this->online : null;
    }

    public function hasBackground()
    {
        return !is_null($this->background);
    }

    public function hasVoteSites()
    {
        return is_array($this->vote_sites) and count($this->vote_sites);
    }

    public function getCssClass()
    {
        $class = [
            'server-partial'
        ];

        if($this->hasBackground()) {
            $class[] = 'has_background';
        }

        return implode(' ', $class);
    }

    public function linkableTemplate($url, $options = [])
    {
        // TODO: Implement name() method.
    }

    public function indexRoute()
    {
        // TODO: Implement indexRoute() method.
    }

    public function showRoute()
    {
        // TODO: Implement showRoute() method.
    }

    public static function createFromApiCollection(Collection $collection)
    {
        return $collection->map(function($item){
            return Server::createFromApi($item);
        });
    }
}