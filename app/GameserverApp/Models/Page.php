<?php

namespace GameserverApp\Models;

use GameserverApp\Helpers\RouteHelper;
use GameserverApp\Interfaces\LinkableInterface;
use GameserverApp\Traits\Linkable;

class Page extends Model implements LinkableInterface
{
    use Linkable;

    public function title()
    {
        return $this->title;
    }

    public function slug()
    {
        return $this->slug;
    }

    public function content()
    {
        return $this->content;
    }

    public function decodedContent()
    {
        $content = $this->content();

        if(is_object($content)) {
            $content = json_decode(json_encode($content), true);
        } elseif(isJson($content)) {
            $content = json_decode($content, true);
        } else {
            $content = mb_unserialize($content);
        }

        return $content;
    }

    public function isBuilder()
    {
        if(!isset($this->pagebuilder)) {
            try {
                unserialize($this->content());
            } catch( \Exception $e) {
                return false;
            }

            return true;
        }

        return $this->pagebuilder;
    }

    public function isRulePage()
    {
        if(RouteHelper::rules() == request()->url()) {
            return true;
        }

        return false;
    }

    public function metaDescription()
    {
        return '';//$this->meta_description;
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