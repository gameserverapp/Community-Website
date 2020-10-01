<?php

namespace GameserverApp\Models;

use GameserverApp\Interfaces\LinkableInterface;
use GameserverApp\Traits\Linkable;
use Illuminate\Support\Str;

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

    public function summary()
    {
        return Str::limit(strip_tags($this->description()));
    }

    public function hasCharacters()
    {
        return $this->characters;
    }

    public function characters()
    {
        return $this->characters;
    }

    public function usage()
    {
        if(!$this->usage) {
            return 0;
        }

        return $this->usage;
    }

    public function limit()
    {
        return $this->limit;
    }

    public function limitDays()
    {
        return $this->limit_days;
    }

    public function isEmptyPack()
    {
        return is_null($this->content_type);
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

    public function hasLimits()
    {
        if($this->limit() == 0 and $this->limitDays() == 0) {
            return 1;
        }

        if($this->limit() == 1 and $this->limitDays() == 365) {
            return 2;
        }

        if($this->limit() == 1 and $this->limitDays() != 365) {
            return 3;
        }

        if($this->limit() != 1 and $this->limitDays() > 0) {
            return 4;
        }


        return 1;
    }

    public function displayLimits()
    {
        switch($this->hasLimits()) {
            case 1:
                return 'Unlimited';

            case 2:
                return 'Once per year';

            case 3:
                return 'Once per ' . $this->limitDays() . ' day(s)';

            default:
                return $this->limit() . ' per ' . $this->limitDays() . ' day(s)';
        }
    }

    public function image()
    {
        return $this->image;
    }

    public function orderUrl()
    {
        return route('shop.purchase', $this->id);
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