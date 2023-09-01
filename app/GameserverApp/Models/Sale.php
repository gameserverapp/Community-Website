<?php

namespace GameserverApp\Models;

use Carbon\Carbon;
use GameserverApp\Interfaces\LinkableInterface;
use GameserverApp\Traits\Linkable;

class Sale extends Model
{

    public function id()
    {
        return $this->id;
    }

    public function currency()
    {
        return $this->currency;
    }

    public function amount()
    {
        return $this->amount;
    }

    public function transactionDate()
    {
        if(is_null($this->date)) {
            return null;
        }

        return Carbon::parse($this->date);
    }

    public function user()
    {
        return $this->user;
    }

    public function hasRelatable()
    {
        return !is_null($this->relatable);
    }

    public function relatable()
    {
        return $this->relatable;
    }

    public function isSubscriptionSale()
    {
        return $this->subscription_sale;
    }

    public function hasInvoiceLink()
    {
        return !is_null($this->invoice_link);
    }

    public function invoiceLink()
    {
        return $this->invoice_link;
    }

    public function discount()
    {
        return $this->discount;
    }

    public function hasDiscount()
    {
        return is_numeric($this->discount());
    }
}