<?php

namespace GameserverApp\Transformers;

use GameserverApp\Interfaces\ModelTransformerInterface;
use GameserverApp\Models\Message;
use GameserverApp\Models\Page;
use GameserverApp\Models\User;

class PageTransformer extends ModelTransformer implements ModelTransformerInterface
{

    public static function model(array $args)
    {
        return new Page($args);
    }

    public static function transformableInput($args)
    {
        $data = [
            'id'           => $args->id,
            'slug'         => $args->slug,
            'title'        => $args->title,
            'description'  => $args->description,
            'content'      => $args->content,
            'published_at' => $args->published_at
        ];

        if (isset($args->pagebuilder)) {
            $data['pagebuilder'] = $args->pagebuilder;
        }

        return $data;
    }
}