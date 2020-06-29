<?php

namespace GameserverApp\Models;

use GameserverApp\Interfaces\LinkableInterface;
use GameserverApp\Traits\Linkable;

class SupportTier extends Model implements LinkableInterface
{
    use Linkable;

    public function name()
    {
        return $this->name;
    }

    public function description()
    {
        return $this->description;
    }

    public function totalPrice()
    {
        return $this->total_price;
    }

    public function displayTotalPrice()
    {
        $suffix = '';

        if($this->isSubscription()) {
            $suffix = ' p/mo';
        }

        return $this->displayCurrency() . '' . $this->totalPrice() . $suffix;
    }

    public function requiresDiscordSetup()
    {
        return $this->requires_discord;
    }

    public function isSubscription()
    {
        return $this->type() == 'subscription';
    }

    public function currency()
    {
        return $this->currency;
    }

    public function type()
    {
        return $this->type;
    }

    public function cluster()
    {
        return $this->cluster;
    }

    public function displayCurrency()
    {
        switch($this->currency()) {
            case 'EUR':
                return '€';

            case 'GBP':
                return '£';

            default:
                return '$';
        }
    }

    public function image()
    {
        return $this->image;
    }

    public function orderUrl()
    {
        return $this->order_url;
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