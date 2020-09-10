<?php

namespace GameserverApp\Transformers;

use GameserverApp\Interfaces\ModelTransformerInterface;
use GameserverApp\Models\Calendar;
use GameserverApp\Models\Message;
use GameserverApp\Models\News;
use GameserverApp\Models\User;

class CalendarTransformer extends ModelTransformer implements ModelTransformerInterface
{

    public static function model(array $args)
    {
        return new Calendar($args);
    }

    public static function transformableInput($args)
    {
        $data = [
            'id'          => $args->id,
            'title'       => $args->title,
            'summary'     => $args->summary,
            'description' => $args->description,
            'image'       => $args->image,
            'start_at'    => $args->start_at,
            'end_at'      => $args->end_at
        ];

        if (isset($args->server)) {
            $data['related'] = ServerTransformer::transform($args->server);
        }

        if (isset($args->cluster)) {
            $data['related'] = ClusterTransformer::transform($args->cluster);
        }

        return $data;
    }
}