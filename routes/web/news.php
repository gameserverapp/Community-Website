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
        'uses' => 'NewsController@show'
    ]);

    Route::get('/news/{id}-{slug}/purge_cache', [
        'as'   => 'news.purge',
        'uses' => 'NewsController@purge'
    ]);
});

