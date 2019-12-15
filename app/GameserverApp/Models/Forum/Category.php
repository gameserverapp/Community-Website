<?php

namespace GameserverApp\Models\Forum;

use Illuminate\Support\Facades\Gate;
use GameserverApp\Interfaces\LinkableInterface;
use GameserverApp\Models\Model;
use GameserverApp\Traits\Linkable;

class Category extends Model implements LinkableInterface
{
    use Linkable;

    public function children()
    {
        $children = $this->categories;

        $children = $children->filter(function ($category) {
            if ($category->private) {
                return Gate::allows('view', $category);
            }

            return true;
        });

        return $children;
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