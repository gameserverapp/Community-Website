<?php

namespace GameserverApp\Models;

use Illuminate\Support\Collection;
use GameserverApp\Interfaces\LinkableInterface;
use GameserverApp\Traits\Linkable;

class Cluster extends Model
{

    public function name()
    {
        return str_limit($this->name, 16, '');
    }

}