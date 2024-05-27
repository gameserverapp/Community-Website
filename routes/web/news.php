<?php

Route::group([
    'prefix' => 'news'
], function ($router) {

    Route::get('/', [
        'as'   => 'news.index',
        'uses' => 'NewsController@index'
    ]);

    Route::get('/{id}-{slug}', [
        'as'   => 'news.show',
        'uses' => 'NewsController@show',
        'middleware' => 'valid_id_slug'
    ]);

    Route::get('/news/{id}-{slug}/purge_cache', [
        'as'   => 'news.purge',
        'uses' => 'NewsController@purge',
        'middleware' => 'valid_id_slug'
    ]);
});

