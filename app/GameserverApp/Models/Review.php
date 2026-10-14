<?php

namespace App\GameserverApp\Models;

use Carbon\Carbon;
use GameserverApp\Interfaces\LinkableInterface;
use GameserverApp\Models\Model;
use GameserverApp\Models\User;
use GameserverApp\Traits\Linkable;

class Review extends Model
{
    public function postDate()
    {
        return $this->date;
    }

    public function score()
    {
        return $this->score;
    }

    public function hasComment()
    {
        return !empty($this->comment) and !is_null($this->comment);
    }

    public function comment()
    {
        return $this->comment;
    }

    public function commentWithBr()
    {
        return str_replace('\n', '<br>', strip_tags($this->comment));
    }

    public function user()
    {
        return $this->user;
    }
}