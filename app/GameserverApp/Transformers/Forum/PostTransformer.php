<?php
namespace GameserverApp\Transformers\Forum;

use App\Http\Controllers\Forum\PostController;
use GameserverApp\Interfaces\ModelTransformerInterface;
use GameserverApp\Models\Forum\Category;
use GameserverApp\Models\Forum\Post;
use GameserverApp\Models\Forum\Thread;
use GameserverApp\Transformers\ModelTransformer;
use GameserverApp\Transformers\UserTransformer;

class PostTransformer extends ModelTransformer implements ModelTransformerInterface
{

    public static function model(array $args)
    {
        return new Post($args);
    }

    public static function transformableInput($args)
    {
        $data = [
            'id'    => $args->id,
            'content' => $args->content,
            'sequence' => $args->sequence,

            'isFirst' => $args->is_first,

            'parent' => (!isset($args->parent) or is_null($args->parent))
                ? null : self::transform($args->parent),

            'created_at'   => $args->created_at,
            'updated_at'   => $args->updated_at,
            'deleted_at'   => $args->deleted_at
        ];

        if(isset($args->url)) {
            $data['url'] = $args->url;
        }

        if (isset($args->thread)) {
            $data['thread'] = ThreadTransformer::transform($args->thread);
        }

        if (isset($args->author)) {
            $data['author'] = UserTransformer::transform($args->author);
        }

        return $data;
    }
}