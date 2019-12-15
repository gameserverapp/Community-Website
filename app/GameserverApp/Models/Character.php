<?php

namespace GameserverApp\Models;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use GameserverApp\Helpers\SiteHelper;
use GameserverApp\Interfaces\LinkableInterface;
use GameserverApp\Traits\Linkable;

class Character extends Model implements LinkableInterface
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
        if(!SiteHelper::featureEnabled('player_status')) {
            return false;
        }

        return (bool)$this->status;
    }

    public function streaming()
    {
        return (bool)$this->streaming;
    }

    public function donated()
    {
        if($this->hasUser()) {
            return $this->user->donated();
        }
    }

    public function tribeOwner()
    {
        if(!isset($this->tribe_owner)) {
            return false;
        }

        return $this->tribe_owner;
    }

    public function tribeAdmin()
    {
        if(!isset($this->tribe_admin)) {
            return false;
        }

        return $this->tribe_admin;
    }

    public function hasServer()
    {
        return isset($this->server);
    }

    public function hasUser()
    {
        return isset($this->user);
    }

    public function hasTribe()
    {
        return isset($this->tribe);
    }

    public function hasGame()
    {
        return isset($this->game);
    }

    public function hoursPlayed()
    {
        return $this->hours_played;
    }

    public function characterImage()
    {
        if ($this->gender) {
            $link = 'male/';
        } else {
            $link = 'female/';
        }

        //selecting gear based on level
        $gear = 'naked';

        if ($this->level > 3) {
            $gear = 'fiber';
        }

        if ($this->level > 20) {
            $gear = 'hide';
        }

        if ($this->level > 25) {
            $gear = 'fur';
        }

        if ($this->level > 30) {
            $gear = 'chitin';
        }

        if ($this->level > 35) {
            $gear = 'ghilli';
        }

        if ($this->level > 45) {
            $gear = 'flak';
        }

        if ($this->level > 80) {
            $gear = 'riot';
        }

        return $link . $gear . '.png';
    }

    //linkable
    public function linkableTemplate($url, $options = [])
    {
        if (! isset($options['limit'])) {
            $options['limit'] = 99;
        }

        $name = str_limit($this->name(), $options['limit'], '...');

        if(isset($options['suffix'])) {
            $name .= $options['suffix'];
        }

        $output = [];

        $output[] = '<span class="linkwrapper" itemscope itemtype="http://schema.org/Person">';

        if (isset($options['disable_link'])) {
            $output[] = '<span class="characterlink-name">';
            $output[] = '<span itemprop="name">' . $name . '</span>';
            $output[] = '</span>';
        } else {
            $output[] = '<a class="characterlink" href="' . $url . '" itemprop="url">';
            $output[] = '<span itemprop="name">' . $name . '</span>';
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
        return route('character.show', $this->id);
    }

    private function statusIndicator($size = 'small')
    {
        if(!SiteHelper::featureEnabled('player_status') and !$this->streaming()) {
            return '';
        }

        $title = '';
        $class = [
            'aftername',
            'online'
        ];

        if ($this->streaming()) {
            $title = 'Streaming with character \'' . $this->name() . '\' since ' . $this->date('status_since')->diffForHumans();
            $class = [
                'aftername',
                'streaming'
            ];
        } else {
            if ($this->donated()) {
                $class[] = 'vip';
                $title .= 'Donor <3 | ';
            }

            $title .= 'Online with character \'' . $this->name() . '\' since ' . $this->date('status_since')->diffForHumans();
        }

        $class = $size . ' ' . implode(' ', $class);

        return '<span title="' . $title . '" class="status  ' . $class . '"></span>';
    }
}