<?php
namespace GameserverApp\Transformers;

use GameserverApp\Interfaces\ModelTransformerInterface;
use GameserverApp\Models\Cluster;
use GameserverApp\Models\Server;
use GameserverApp\Models\User;

class ClusterTransformer extends ModelTransformer implements ModelTransformerInterface
{

    public static function model(array $args)
    {
        return new Cluster($args);
    }

    public static function transformableInput($args)
    {
        $data = [
            'id'         => $args->id,
            'name'       => $args->name,
        ];

        return $data;
    }
}