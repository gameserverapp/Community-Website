<?php

Route::group([
    'prefix' => 'supporter-tier'
], function ($router) {

    Route::get('/', [
        'as'   => 'supporter-tier.index',
        'uses' => 'SupporterTierController@index',
    ]);
    
    Route::get('/show/{id}', [
        'as'   => 'supporter-tier.show',
        'uses' => 'SupporterTierController@show',
        'middleware' => 'valid_uuid'
    ]);

    Route::get('/show/{id}/purge_cache', [
        'as'   => 'supporter-tier.purge',
        'uses' => 'SupporterTierController@purge',
        'middleware' => 'valid_uuid'
    ]);
});

