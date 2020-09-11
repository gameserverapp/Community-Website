<?php

namespace GameserverApp\Models;

use GameserverApp\Interfaces\LinkableInterface;
use GameserverApp\Traits\Linkable;

class Calendar extends Model implements LinkableInterface
{
    
    use Linkable;

    public function title()
    {
        return $this->title;
    }

    public function summary()
    {
        return $this->summary;
    }

    public function description()
    {
        return $this->description;
    }

    public function metaDescription()
    {
        return $this->summary;
    }

    public function hasRelated()
    {
        return isset($this->related) and !is_null($this->related);
    }

    public function displayRelated()
    {
        if($this->related instanceof Server) {
            return 'Server: ' . $this->related->name();
        }

        if($this->related instanceof Cluster) {
            return 'Cluster: ' . $this->related->name();
        }
    }

    public function hasImage()
    {
        return isset($this->image) and $this->image;
    }

    public function image()
    {
        return $this->image;
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