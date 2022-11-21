<?php

namespace GameserverApp\Models;

use GameserverApp\Interfaces\LinkableInterface;
use GameserverApp\Traits\Linkable;

class Token extends Model implements LinkableInterface
{
    use Linkable;

    public function name()
    {
        return $this->name;
    }

    public function quantity()
    {
        return $this->quantity;
    }

    public function displayQuantity()
    {
        if ($this->quantity() == 1) {
            return '1 token';
        }

        return $this->quantity() . ' tokens';
    }

    public function totalPrice()
    {
        return $this->total_price;
    }

    public function displayTotalPrice()
    {
        return $this->displayCurrency() . ' ' . $this->totalPrice();
    }

    public function tokenPrice()
    {
        return number_format($this->token_price, 2);
    }

    public function displayTokenPrice()
    {
        return $this->displayCurrency() . ' ' . $this->tokenPrice();
    }

    public function currency()
    {
        return $this->currency;
    }

    public function displayCurrency()
    {
        switch($this->currency()) {
            case 'EUR':
                return '€';

            case 'GBP':
                return '£';

            case 'BRL':
                return 'R$';

            case 'AUD':
                return 'A$';

            case 'CAD':
                return 'C$';

            case 'PLN':
                return 'zł';

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