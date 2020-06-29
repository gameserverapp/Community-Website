<?php

Route::group([
    'prefix' => 'subscription'
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

