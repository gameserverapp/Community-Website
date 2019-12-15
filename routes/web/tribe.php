<?php

Route::group([
    'prefix' => 'tribe/{uuid}'
], function ($router) {

    Route::get('/', [
        'as'   => 'tribe.show',
        'uses' => 'TribeController@show'
    ]);

    Route::get('/members', [
        'as'   => 'tribe.members',
        'uses' => 'TribeController@members'
    ]);

    Route::get('/statistics', [
        'as'   => 'tribe.statistics',
        'uses' => 'TribeController@statistics'
    ]);

    Route::get('/log', [
        'as'   => 'tribe.log',
        'uses' => 'TribeController@log'
    ]);

    Route::get('/promote', [
        'as'   => 'tribe.promote',
        'uses' => 'TribeController@promote'
    ]);

    Route::get('/settings', [
        'as'   => 'tribe.settings',
        'uses' => 'TribeController@settings'
    ]);

    Route::post('/settings', [
        'as'   => 'tribe.settings.save',
        'uses' => 'TribeController@storeSettings'
    ]);
});

