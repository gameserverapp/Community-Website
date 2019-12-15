<?php

namespace GameserverApp\Models;

use GameserverApp\Interfaces\LinkableInterface;
use GameserverApp\Traits\Linkable;

class Transaction extends Model
{

    public function name()
    {
        return $this->name;
    }

    public function transactionValue()
    {
        return $this->transaction_value;
    }

    public function transactionType()
    {
        return $this->transaction_type;
    }

    public function receiver()
    {

    }

    public function sender()
    {
        
    }

}