<?php
namespace GameserverApp\Transformers\Forum;

use GameserverApp\Interfaces\ModelTransformerInterface;
use GameserverApp\Models\Forum\Category;
use GameserverApp\Transformers\ModelTransformer;

class CategoryTransformer extends ModelTransformer implements ModelTransformerInterface
{

    public static function model(array $args)
    {
        return new Category($args);
    }

    public static function transformableInput($args)
    {
        $data = [
            'id'          => $args->id,
            'title'       => $args->title,
            'description' => $args->description,

            'weight'         => $args->weight,
            'threadsEnabled' => $args->enable_threads,
            'private'        => $args->private,

            'thread_count' => $args->thread_count,
            'post_count'   => $args->post_count,
            'depth'   => $args->depth,

            'parent' => (!isset($args->parent) or is_null($args->parent))
                    ? null : self::transform($args->parent),

            'categories' => (!isset($args->categories) or is_null($args->categories))
                    ? collect([]) : self::transformMultiple($args->categories)
        ];

        if (isset($args->threadsPaginated)) {
            $data['threadsPaginated'] = self::fillPaginated(
                $args->threadsPaginated,
                new ThreadTransformer()
            );
        }

        if (isset($args->newest_thread)) {
            $data['newestThread'] = ThreadTransformer::transform($args->newest_thread);
        } else {
            $data['newestThread'] = false;
        }

        if (isset($args->lastest_active_thread)) {
            $data['latestActiveThread'] = ThreadTransformer::transform($args->lastest_active_thread);
        } else {
            $data['latestActiveThread'] = false;
        }

        return $data;
    }
}