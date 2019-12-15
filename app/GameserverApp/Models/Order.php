<?php

namespace GameserverApp\Models;

use GameserverApp\Interfaces\LinkableInterface;
use GameserverApp\Traits\Linkable;

class Order extends Model
{
    const STATUS_PROCESSING = 'processing';
    const STATUS_FULL_INVENTORY = 'inventory_full';
    const STATUS_DELIVERED = 'delivered';
    const STATUS_PICKEDUP = 'picked_up';

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