<?php

namespace GameserverApp\Models\Forum;

use GameserverApp\Interfaces\LinkableInterface;
use GameserverApp\Models\Model;
use GameserverApp\Traits\Linkable;

class Post extends Model implements LinkableInterface
{
    use Linkable;

    public function getPerPage()
    {
        return 15;
    }

    public function trashed()
    {
        return !is_null($this->deleted_at);
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