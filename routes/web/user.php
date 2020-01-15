<?php

Route::group([
    'prefix' => 'user'
], function ($router) {

    Route::get('/{uuid}', [
        'as'   => 'user.show',
        'uses' => 'UserController@show'
    ]);

    Route::get('/{uuid}/settings', [
        'as'   => 'user.settings',
        'uses' => 'UserController@settings',
        'middleware' => 'auth'
    ]);

    Route::post('/{uuid}/settings', [
        'as'   => 'user.settings.store',
        'uses' => 'UserController@storeSettings',
        'middleware' => 'auth'
    ]);

    Route::post('/{uuid}/accept_rules', [
        'as'   => 'user.accept_rules',
        'uses' => 'UserController@acceptRules',
        'middleware' => 'auth'
    ]);

    Route::post('/{uuid}/kick', [
        'as'   => 'user.kick',
        'uses' => 'UserController@kick',
        'middleware' => 'auth'
    ]);

    Route::get('/{uuid}/confirm_email', [
        'as'   => 'user.confirm_email',
        'uses' => 'UserController@confirmEmail',
        'middleware' => 'auth'
    ]);

    Route::get('/{uuid}/confirm_email/resend', [
        'as'   => 'user.confirm_email.resend',
        'uses' => 'UserController@resendConfirmEmail',
        'middleware' => 'auth'
    ]);


    Route::group([
        'prefix' => 'twitch'
    ], function ($router) {

        Route::get('/connect', [
            'as'   => 'user.twitch.connect',
            'uses' => 'TwitchController@connect',
            'middleware' => 'auth'
        ]);

        Route::get('/success', [
            'as'   => 'user.twitch.success',
            'uses' => 'TwitchController@success',
            'middleware' => 'auth'
        ]);

        Route::get('/failed', [
            'as'   => 'user.twitch.failed',
            'uses' => 'TwitchController@failed',
            'middleware' => 'auth'
        ]);

        Route::post('/sync', [
            'as'   => 'user.twitch.sync',
            'uses' => 'TwitchController@sync',
            'middleware' => 'auth'
        ]);

        Route::post('/disconnect', [
            'as'   => 'user.twitch.disconnect',
            'uses' => 'TwitchController@disconnect',
            'middleware' => 'auth'
        ]);
    });

    Route::group([
        'prefix' => 'discord'
    ], function ($router) {

        Route::get('/connect', [
            'as'   => 'user.discord.connect',
            'uses' => 'DiscordController@connect',
            'middleware' => 'auth'
        ]);

        Route::post('/disconnect', [
            'as'   => 'user.discord.disconnect',
            'uses' => 'DiscordController@disconnect',
            'middleware' => 'auth'
        ]);

        Route::get('/success', [
            'as'   => 'user.discord.success',
            'uses' => 'DiscordController@success'
        ]);

        Route::get('/failed', [
            'as'   => 'user.discord.failed',
            'uses' => 'DiscordController@failed'
        ]);
    });

    Route::group([
        'prefix' => 'forum',
        'namespace' => 'Forum'
    ], function ($router) {

        Route::get('/subscribe/{threadId}', [
            'as'   => 'user.forum.subscribe',
            'uses' => 'SubscribeController@subscribe',
            'middleware' => 'auth'
        ]);

        Route::get('/unsubscribe/{threadId}', [
            'as'   => 'user.forum.unsubscribe',
            'uses' => 'SubscribeController@unsubscribe',
            'middleware' => 'auth'
        ]);
    });


});

