<?php

namespace GameserverApp\Models;

use Bugsnag\BugsnagLaravel\Facades\Bugsnag;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use GameserverApp\Helpers\SiteHelper;
use GameserverApp\Interfaces\LinkableInterface;
use GameserverApp\Traits\Linkable;
use Illuminate\Support\Facades\Cache;

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

    public function groupOwner($group)
    {
        if(!isset($group->owners)) {
            return false;
        }

        $ownerIds = $group->owners;

        return in_array($this->user->id, $ownerIds);
    }

    public function groupAdmin($group)
    {
        if($this->groupOwner($group)) {
            return true;
        }

        if(!isset($group->admins)) {
            return false;
        }

        $ownerIds = $group->admins;

        return in_array($this->user->id, $ownerIds);
    }

    public function hasServer()
    {
        return isset($this->server);
    }

    public function hasUser()
    {
        return isset($this->user);
    }

    public function hasGroup()
    {
        return isset($this->groups) and count($this->groups) > 0;
    }

    public function isGroupMember(Group $group)
    {
        if(!$this->hasGroup()) {
            return false;
        }

        $groups = array_filter($this->groups, function($item) use ($group) {
            return $group->id == $item->id;
        });

        return count($groups) > 0;
    }

    public function hasGame()
    {
        return isset($this->game);
    }

    public function hoursPlayed()
    {
        return $this->hours_played;
    }

    public function image()
    {
        try {
            if ($this->gender) {
                $gender = 'male';
            } else {
                $gender = 'female';
            }

            $level = $this->level;

            $cacheKey = domain() . $gender . $level;

            if(Cache::has($cacheKey)) {
                return Cache::get($cacheKey);
            }

            $set = (array) SiteHelper::customCharacterImages()->$gender;
            $options = array_keys($set);

            $key = getReached($level, $options);

            $url = $set[$key];

            Cache::put($key, $url, Carbon::now()->addMinutes(1));

            return $url;
        } catch( \Exception $e) {
            Bugsnag::notifyException($e);
        }
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
                $title .= 'Supporter <3 | ';
            }

            $title .= 'Online with character \'' . $this->name() . '\' since ' . $this->date('status_since')->diffForHumans();
        }

        $class = $size . ' ' . implode(' ', $class);

        return '<span title="' . $title . '" class="status  ' . $class . '"></span>';
    }
}