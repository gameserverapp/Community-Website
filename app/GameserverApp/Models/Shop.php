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

    public function hasLabel()
    {
        return !is_null($this->label);
    }

    public function label()
    {
        return $this->label;
    }

    public function type()
    {
        return $this->type;
    }

    public function isSingle()
    {
        return $this->type() == 'single';
    }

    public function isCollection()
    {
        return $this->type() == 'collection';
    }

    public function requiresCharacterSelect()
    {
        return $this->requires_character;
    }

    public function hasCharacters()
    {
        return $this->characters;
    }

    public function characters()
    {
        return $this->characters;
    }

    public function hasChildren()
    {
        return isset($this->children);
    }

    public function children()
    {
        if(!$this->hasChildren()) {
            return [];
        }

        return $this->children;
    }

    public function usage()
    {
        if(!$this->limit->used) {
            return 0;
        }

        return $this->limit->used;
    }

    public function limit()
    {
        return $this->limit->limit;
    }

    public function limitDays()
    {
        return $this->limit->limit_days;
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
        return $this->limit->limit_text;
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