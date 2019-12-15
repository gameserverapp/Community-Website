<?php

namespace GameserverApp\Models;

use Carbon\Carbon;

class Model
{
    public function __construct($data)
    {
        foreach($data as $key => $value) {
            $this->{$key} = $value;
        }
    }

    public function date($key)
    {
        return Carbon::parse($this->{$key});
    }

    public function hasBeenUpdated()
    {
        return ($this->updated_at > $this->created_at);
    }
}