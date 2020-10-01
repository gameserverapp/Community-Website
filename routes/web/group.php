<?php

Route::group([
    'prefix' => 'group/{uuid}'
], function ($router) {

    Route::get('/', [
        'as'   => 'group.show',
        'uses' => 'GroupController@show'
    ]);

    Route::get('/statistics', [
        'as'   => 'group.statistics',
        'uses' => 'GroupController@statistics'
    ]);

    Route::get('/log', [
        'as'   => 'group.log',
        'uses' => 'GroupController@log'
    ]);

//    Route::get('/promote', [
//        'as'   => 'group.promote',
//        'uses' => 'GroupController@promote'
//    ]);

    Route::get('/settings', [
        'as'   => 'group.settings',
        'uses' => 'GroupController@settings'
    ]);

    Route::post('/settings', [
        'as'   => 'group.settings.save',
        'uses' => 'GroupController@storeSettings'
    ]);

    Route::post('/visual', [
        'as'   => 'group.visual.save',
        'uses' => 'GroupController@storeVisual'
    ]);


    Route::group([
        'prefix' => 'settings/discord',
        'middleware' => 'auth'
    ], function ($router) {

        Route::post('/set-channel', [
            'as'   => 'group.discord.save',
            'uses' => 'GroupController@discordSetChannel'
        ]);

        Route::post('/disconnect', [
            'as'   => 'group.discord.disconnect',
            'uses' => 'GroupController@disconnectDiscord'
        ]);

        Route::get('/{status}', [
            'as'   => 'group.discord.status',
            'uses' => 'GroupController@discordStatus',
        ]);
    });
});

