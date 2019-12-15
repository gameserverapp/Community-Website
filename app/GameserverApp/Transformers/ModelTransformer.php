<?php
namespace GameserverApp\Transformers;


use Illuminate\Pagination\LengthAwarePaginator;

class ModelTransformer
{

    public static function transform($data)
    {
        return static::model(
            static::transformableInput($data)
        );
    }

    public static function transformMultiple($items)
    {
        if($items instanceof \Exception) {
            return collect([]);
        }

        $items = collect($items);

        return $items->map(function($item){
            return self::transform($item);
        });
    }

    protected static function fillPaginated($data, ModelTransformer $transformer)
    {
        return new LengthAwarePaginator(
            $transformer->transformMultiple($data->data),
            $data->total,
            $data->per_page,
            $data->current_page,
            [
                'path' => url()->current()
            ]
        );
    }
}