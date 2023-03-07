<?php

Route::group([
    'prefix' => 'user'
], function ($router) {


    Route::post('/switch-theme', [
        'as'   => 'user.switch-theme',
        'uses' => 'UserController@switchTheme'
    ]);

    Route::get('/{uuid}', [
        'as'   => 'user.show',
        'uses' => 'UserController@show'
    ]);

    Route::get('/{uuid}/activity', [
        'as'   => 'user.activity',
        'uses' => 'UserController@activity'
    ]);

    Route::get('/{uuid}/about', [
        'as'   => 'user.about',
        'uses' => 'UserController@about'
    ]);

    Route::get('/{uuid}/order-history', [
        'as'   => 'shop.orders',
        'uses' => 'UserController@orderHistory',
        'middleware' => 'auth'
    ]);

    Route::get('/{uuid}/deliveries', [
        'as'   => 'user.deliveries',
        'uses' => 'UserController@deliveries',
        'middleware' => 'auth'
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

    Route::group([
        'prefix' => '/{uuid}/subscription',
        'middleware' => 'auth'
    ], function ($router) {

        Route::get('/', [
            'as'   => 'subscription.index',
            'uses' => 'SubscriptionController@index',
        ]);

        Route::post('/{id}/change_character', [
            'as'   => 'subscription.change_character',
            'uses' => 'SubscriptionController@changeCharacter'
        ]);

        Route::post('/{id}/cancel', [
            'as'   => 'subscription.cancel',
            'uses' => 'SubscriptionController@cancel'
        ]);
    });

    Route::group([
        'prefix' => '/{uuid}/message',
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

        Route::get('/create', [
            'as'   => 'message.create',
            'uses' => 'MessageController@create'
        ]);

        Route::post('/create', [
            'as'   => 'message.send',
            'uses' => 'MessageController@send'
        ]);

        Route::get('/show/{id}', [
            'as'   => 'message.show',
            'uses' => 'MessageController@show'
        ]);
    });

    Route::group([
        'prefix' => '/{uuid}/token',
        'middleware' => 'auth'
    ], function ($router) {

        Route::get('/', [
            'as'   => 'token.index',
            'uses' => 'TokenController@index'
        ]);

        Route::get('/send', [
            'as'   => 'token.send',
            'uses' => 'TokenController@send'
        ]);

        Route::post('/send', [
            'as'   => 'token.send-submit',
            'uses' => 'TokenController@sendSubmit'
        ]);

    });


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
        'prefix' => 'patreon'
    ], function ($router) {

        Route::get('/connect', [
            'as'   => 'user.patreon.connect',
            'uses' => 'PatreonController@connect',
            'middleware' => 'auth'
        ]);

        Route::post('/disconnect', [
            'as'   => 'user.patreon.disconnect',
            'uses' => 'PatreonController@disconnect',
            'middleware' => 'auth'
        ]);

        Route::get('/success', [
            'as'   => 'user.patreon.success',
            'uses' => 'PatreonController@success'
        ]);

        Route::get('/failed', [
            'as'   => 'user.patreon.failed',
            'uses' => 'PatreonController@failed'
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

