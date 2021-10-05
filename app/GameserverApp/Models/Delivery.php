<?php

namespace GameserverApp\Models;

use GameserverApp\Interfaces\LinkableInterface;
use GameserverApp\Traits\Linkable;

class Delivery extends Model
{
    const STATUS_CREATED = 0;
    const STATUS_IN_PROGRESS = 1;
    const STATUS_ISSUE = 2;
    const STATUS_SUCCESS = 3;
    const STATUS_FULL_INVENTORY = 4;
    const STATUS_WAITING_PLAYER_COME_ONLINE = 5;
    const STATUS_UNDELIVERABLE = 999;

    public function name()
    {
        return $this->name;
    }

    public function transactionId()
    {
        return $this->transaction_id;
    }

    public function status()
    {
        return $this->status;
    }
}