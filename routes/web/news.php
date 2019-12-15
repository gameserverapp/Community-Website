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

});

