<?php

namespace GameserverApp\Models;

use Carbon\Carbon;
use GameserverApp\Interfaces\LinkableInterface;
use GameserverApp\Traits\Linkable;
use Illuminate\Support\Str;

class Calendar extends Model implements LinkableInterface
{
    
    use Linkable;

    public function title()
    {
        return $this->title;
    }

    public function slug()
    {
        return Str::slug($this->title());
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

    public function startAt()
    {
        return $this->date('start_at');
    }

    public function endAt()
    {
        return $this->date('end_at');
    }

    public function hasRelated()
    {
        return isset($this->related) and !is_null($this->related);
    }

    public function currentlyActive()
    {
        return $this->startAt() < Carbon::now() and $this->endAt() > Carbon::now();
    }

    public function displayLabel()
    {
        $label = [];

        if($this->currentlyActive()) {
            $label[] = translate('currently_active', 'Currently active');
        }

        if($this->hasRelated()) {
            $label[] = $this->displayRelated();
        }

        return $label;
    }

    public function displayRelated()
    {
        if($this->related instanceof Server) {
            return '[Server] ' . $this->related->name();
        }

        if($this->related instanceof Cluster) {
            return '[Cluster] ' . $this->related->name();
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
        return route('calendar.show', [$this->id, $this->slug()]);
    }
}