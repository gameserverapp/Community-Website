<?php

namespace App\GameserverApp\Transformers;

use App\GameserverApp\Models\Review;
use Carbon\Carbon;
use GameserverApp\Interfaces\ModelTransformerInterface;
use GameserverApp\Transformers\ModelTransformer;
use GameserverApp\Transformers\UserTransformer;

class ReviewTransformer extends ModelTransformer implements ModelTransformerInterface
{

    public static function model(array $args)
    {
        return new Review($args);
    }

    public static function transformableInput($args)
    {
        $data = [
            'date' => Carbon::parse($args->date),
            'score' => $args->score,
            'comment' => $args->comment
        ];

        if (isset($args->user)) {
            $data['user'] = UserTransformer::transform($args->user);
        }

        return $data;
    }
}