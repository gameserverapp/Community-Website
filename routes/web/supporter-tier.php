<?php

Route::group([
    'prefix' => 'supporter-tier'
], function ($router) {

    Route::get('/', [
        'as'   => 'supporter-tier.index',
        'uses' => 'SupporterTierController@index',
        'middleware' => 'auth'
    ]);
    
    Route::get('/show/{id}', [
        'as'   => 'supporter-tier.show',
        'uses' => 'SupporterTierController@show'
    ]);

    Route::get('/buy', [
        'as'   => 'supporter-tier.buy',
        'uses' => 'SupporterTierController@buy'
    ]);

});

