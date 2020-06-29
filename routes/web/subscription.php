<?php

Route::group([
    'prefix' => 'subscription'
], function ($router) {

    Route::get('/', [
        'as'   => 'subscription.index',
        'uses' => 'SubscriptionController@index',
    ]);
    
    Route::get('/{id}/changeCharacter', [
        'as'   => 'subscription.change_character',
        'uses' => 'SubscriptionController@changeCharacter'
    ]);

    Route::get('/{id}/cancel', [
        'as'   => 'subscription.cancel',
        'uses' => 'SubscriptionController@cancel'
    ]);
});

