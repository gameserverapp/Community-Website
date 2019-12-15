<?php

Route::group([
    'prefix' => 'token'
], function ($router) {

    Route::get('/', [
        'as'   => 'token.index',
        'uses' => 'TokenController@index',
        'middleware' => 'auth'
    ]);
    
    Route::get('/show/{id}', [
        'as'   => 'token.show',
        'uses' => 'TokenController@show'
    ]);

    Route::get('/buy', [
        'as'   => 'token.buy',
        'uses' => 'TokenController@buy'
    ]);

});

