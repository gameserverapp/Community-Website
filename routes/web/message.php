<?php

Route::group([
    'prefix' => 'message',
    'middleware' => 'auth'
], function ($router) {

    Route::get('/', [
        'as'   => 'message.index',
        'uses' => 'MessageController@index'
    ]);

    Route::get('/inbox', [
        'as'   => 'message.inbox',
        'uses' => 'MessageController@inbox'
    ]);

    Route::get('/outbox', [
        'as'   => 'message.outbox',
        'uses' => 'MessageController@outbox'
    ]);

    Route::get('/create/{uuid}', [
        'as'   => 'message.create',
        'uses' => 'MessageController@create'
    ]);

    Route::post('/create/{uuid}', [
        'as'   => 'message.send',
        'uses' => 'MessageController@send'
    ]);

    Route::get('/show/{uuid}', [
        'as'   => 'message.show',
        'uses' => 'MessageController@show'
    ]);

});

