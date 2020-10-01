<?php

Route::group([
    'prefix' => 'shop'
], function ($router) {

    Route::get('/', [
        'as'   => 'shop.index',
        'uses' => 'ShopController@index'
    ]);

    Route::get('/{id}/show', [
        'as'   => 'shop.show',
        'uses' => 'ShopController@show'
    ]);

    Route::post('/{id}/purchase', [
        'as'   => 'shop.purchase',
        'uses' => 'ShopController@purchase',
        'middleware' => 'auth'
    ]);

});

