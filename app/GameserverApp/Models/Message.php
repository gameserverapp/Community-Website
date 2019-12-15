<?php

namespace GameserverApp\Models;

use GameserverApp\Interfaces\LinkableInterface;
use GameserverApp\Traits\Linkable;

class Message extends Model implements LinkableInterface
{
    use Linkable;

    public function read()
    {
        if(!isset($this->read)) {
            return true;
        }

        return isset($this->read) and $this->read;
    }

    public function subject()
    {
        return $this->subject;
    }

    public function content()
    {
        return $this->content;
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