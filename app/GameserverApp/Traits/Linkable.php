<?php

namespace GameserverApp\Traits;

trait Linkable
{
    public function indexLink($options = [])
    {
        return $this->linkableTemplate($this->indexRoute(), $options);
    }

    public function showLink($options = [])
    {
        return $this->linkableTemplate($this->showRoute(), $options);
    }

    public function showName($options = [])
    {
        $options['disable_link'] = true;

        return $this->showLink($options);
    }
}