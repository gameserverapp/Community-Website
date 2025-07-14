<?php

namespace GameserverApp\Models;

use Carbon\Carbon;
use GameserverApp\Interfaces\LinkableInterface;
use GameserverApp\Traits\Linkable;

class Sale extends Model
{


    // Payment status constants
    const STATUS_PENDING = 0;
    const STATUS_COMPLETED = 1;
    const STATUS_FAILED = 2;
    const STATUS_REFUNDED = 3;
    const STATUS_CANCELLED = 4;
    const STATUS_EXPIRED = 5;

    public function id()
    {
        return $this->id;
    }

    public function status()
    {
        return $this->status;
    }

    public function displayStatusLabel()
    {
        switch ($this->status) {
            case self::STATUS_PENDING:
                return '<span class="label label-warning">Pending</span>';

            case self::STATUS_COMPLETED:
                return '<span class="label label-success">Completed</span>';

            case self::STATUS_FAILED:
                return '<span class="label label-danger">Failed</span>';

            case self::STATUS_REFUNDED:
                return '<span class="label label-default">Refunded</span>';

            case self::STATUS_CANCELLED:
                return '<span class="label label-default">Cancelled</span>';

            case self::STATUS_EXPIRED:
                return '<span class="label label-default">Expired</span>';
        }
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