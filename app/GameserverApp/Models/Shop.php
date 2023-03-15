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
        return !is_null($this->label());
    }

    public function label()
    {
        if(
            $this->isSingle() and
            $this->tokenPrice() != 0 and
            $discount = $this->discount()
        ) {
            return $discount . '% discount';
        }

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

    public function requiresDiscordConnected()
    {
        return $this->requires_discord;
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

    public function discountedPrice()
    {
        return $this->discounted_token_price;
    }

    public function discount()
    {
        return $this->discount;
    }

    public function displayTokenPrice()
    {
        if($this->tokenPrice() == 0) {
            return 'Free';
        }

        if($this->discount()) {
            return '<span class="discounted_price">
                        <span class="from_price">From: <span>' . $this->tokenSuffix($this->tokenPrice()) . '</span></span><br>
                        <span class="to_price">To: <span>' . $this->tokenSuffix($this->discountedPrice()) . '</span></span>
                    </span>';
        }

        return $this->tokenSuffix($this->tokenPrice());
    }

    private function tokenSuffix($amount)
    {
        if($amount == 1) {
            return $amount . ' token';
        }

        return $amount . ' tokens';
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