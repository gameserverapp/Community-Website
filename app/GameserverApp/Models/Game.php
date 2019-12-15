<?php

namespace GameserverApp\Models;

use Illuminate\Support\Collection;
use GameserverApp\Interfaces\LinkableInterface;
use GameserverApp\Traits\Linkable;

class Game extends Model
{

    public function name()
    {
        return str_limit($this->name, 16, '');
    }

    public function steamClientId()
    {
        return $this->steam_client_id;
    }

    public function steamServerId()
    {
        return $this->steam_server_id;
    }

    public function supportDelivery()
    {
        return $this->support_delivery;
    }

    public function supportLevel()
    {
        return $this->support_level;
    }

    public function supportGender()
    {
        return $this->support_gender;
    }

    public function groupName()
    {
        switch($this->steamServerId()) {
            case 376030:
                return 'tribe';

            case 1006030:
                return 'company';

            default:
                return 'group';
        }
    }

    public static function createFromApiCollection(Collection $collection)
    {
        return $collection->map(function($item){
            return Game::createFromApi($item);
        });
    }
}