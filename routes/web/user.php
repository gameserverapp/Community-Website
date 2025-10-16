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
    });
    
    Route::group([
        'prefix' => '/me',
        'middleware' => ['auth']
    ], function ($router) {

        Route::get('/deliveries', [
            'as'   => 'user.deliveries',
            'uses' => 'UserController@deliveries'
        ]);

        Route::get('/invoices', [
            'as'   => 'user.invoices',
            'uses' => 'UserController@invoices'
        ]);

        Route::get('/invoices/{sale_id}/download', [
            'as'   => 'user.invoices.download',
            'uses' => 'UserController@downloadInvoice'
        ]);

        Route::get('/settings', [
            'as'   => 'user.settings',
            'uses' => 'UserController@settings'
        ]);

        Route::post('/settings', [
            'as'   => 'user.settings.store',
            'uses' => 'UserController@storeSettings'
        ]);

        Route::group([
            'prefix' => '/subscription'
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
            'prefix' => '/message'
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

            Route::get('/create/{id}', [
                'as'   => 'message.create',
                'uses' => 'MessageController@create'
            ]);

            Route::post('/create/{id}', [
                'as'   => 'message.send',
                'uses' => 'MessageController@send'
            ]);

            Route::get('/show/{id}', [
                'as'   => 'message.show',
                'uses' => 'MessageController@show'
            ]);
        });

        Route::group([
            'prefix' => '/token'
        ], function ($router) {

            Route::get('/', [
                'as'   => 'token.index',
                'uses' => 'TokenController@index'
            ]);

            Route::get('/send/{uuid}', [
                'as'   => 'token.send',
                'uses' => 'TokenController@send'
            ]);

            Route::post('/send/{uuid}', [
                'as'   => 'token.send-submit',
                'uses' => 'TokenController@sendSubmit'
            ]);
        });

        Route::post('/accept_rules/{access_group_id}', [
            'as'   => 'user.accept_rules',
            'uses' => 'UserController@acceptRules'
        ]);

        Route::post('/kick', [
            'as'   => 'user.kick',
            'uses' => 'UserController@kick'
        ]);

        Route::get('/confirm_email', [
            'as'   => 'user.confirm_email',
            'uses' => 'UserController@confirmEmail'
        ]);

        Route::get('/confirm_email/resend', [
            'as'   => 'user.confirm_email.resend',
            'uses' => 'UserController@resendConfirmEmail'
        ]);

        Route::group([
            'prefix' => 'forum',
            'namespace' => 'Forum'
        ], function ($router) {

            Route::get('/subscribe/{threadId}', [
                'as'   => 'user.forum.subscribe',
                'uses' => 'SubscribeController@subscribe'
            ]);

            Route::get('/unsubscribe/{threadId}', [
                'as'   => 'user.forum.unsubscribe',
                'uses' => 'SubscribeController@unsubscribe'
            ]);
        });

        Route::group([
            'prefix' => 'me/sub_users',
        ], function ($router) {

            Route::post('/connect', [
                'as'   => 'user.sub_user.connect',
                'uses' => 'SubUserController@connect'
            ]);

            Route::post('/disconnect/{sub_uuid}', [
                'as'   => 'user.sub_user.disconnect',
                'uses' => 'SubUserController@disconnect'
            ]);

            Route::get('/issue-reverse-code', [
                'as'   => 'user.sub_user.issue_reverse_code',
                'uses' => 'SubUserController@issueToken',
            ]);
        });
    });
});

