<?php

namespace GameserverApp\Models;

use GameserverApp\Interfaces\LinkableInterface;
use GameserverApp\Traits\Linkable;

class Shop extends Model implements LinkableInterface
{
    use Linkable;

    public function name($limit = 999)
    {
        return str_limit($this->name, $limit);
    }

    public function description()
    {
        return $this->description;
    }

    public function limit()
    {
        return $this->limit;
    }

    public function limitDays()
    {
        return $this->limit_days;
    }

    public function tokenPrice()
    {
        return $this->token_price;
    }

    public function displayTokenPrice()
    {
        if($this->tokenPrice() == 0) {
            return 'Free';
        }

        if($this->tokenPrice() == 1) {
            return '1 token';
        }

        return $this->tokenPrice() . ' tokens';
    }

    public function image()
    {
        return $this->image;
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

}