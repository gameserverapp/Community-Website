<?php
namespace GameserverApp\Transformers\Forum;

use GameserverApp\Interfaces\ModelTransformerInterface;
use GameserverApp\Models\Forum\Thread;
use GameserverApp\Transformers\ModelTransformer;

class ThreadTransformer extends ModelTransformer implements ModelTransformerInterface
{

    public static function model(array $args)
    {
        return new Thread($args);
    }

    public static function transformableInput($args)
    {
        $data = [
            'id'    => $args->id,
            'title' => $args->title,

            'pinned'  => $args->pinned,
            'locked'  => $args->locked,
            'reply_count' => $args->reply_count,

            'userReadStatus' => $args->user_read_status,

            'created_at'   => $args->created_at,
            'updated_at'   => $args->updated_at,
            'deleted_at'   => $args->deleted_at
        ];

        if (isset($args->category)) {
            $data['category'] = CategoryTransformer::transform($args->category);
        }

        if (isset($args->posts)) {
            $data['posts'] = PostTransformer::transformMultiple($args->posts);
        }

        if (isset($args->first_post)) {
            $data['firstPost'] = PostTransformer::transform($args->first_post);
        }

        if (isset($args->last_post)) {
            $data['lastPost'] = PostTransformer::transform($args->last_post);
        }

        if (isset($args->postsPaginated)) {
            $data['postsPaginated'] = self::fillPaginated(
                $args->postsPaginated,
                new PostTransformer()
            );
        }

        return $data;
    }
}