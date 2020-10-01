<?php

namespace GameserverApp\Models;

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
        return $this->date;
    }

    public function user()
    {
        return $this->user;
    }
}