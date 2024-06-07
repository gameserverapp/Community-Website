<?php

Route::group([
    'prefix' => 'user'
], function ($router) {

    Route::post('/switch-theme', [
        'as'   => 'user.switch-theme',
        'uses' => 'UserController@switchTheme'
    ]);

    Route::group([
        'middleware' => 'valid_uuid'
    ], function ($router) {

        Route::get('/{uuid}', [
            'as'   => 'user.show',
            'uses' => 'UserController@show',
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

        Route::get('/{uuid}/invoices', [
            'as'   => 'user.invoices',
            'uses' => 'UserController@invoices',
            'middleware' => 'auth'
        ]);

        Route::get('/{uuid}/invoices/{sale_id}/download', [
            'as'   => 'user.invoices.download',
            'uses' => 'UserController@downloadInvoice',
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

    Route::group([
        'prefix' => 'me/sub_users',
        'middleware' => 'auth'
    ], function ($router) {

        Route::post('/connect', [
            'as'   => 'user.sub_user.connect',
            'uses' => 'SubUserController@connect',
        ]);

        Route::post('/disconnect/{sub_uuid}', [
            'as'   => 'user.sub_user.disconnect',
            'uses' => 'SubUserController@disconnect',
        ]);
    });
});

