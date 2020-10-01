<?php

Route::group([
    'prefix' => 'character'
], function ($router) {

    Route::get('/{uuid}', [
        'as'   => 'character.show',
        'uses' => 'CharacterController@show'
    ]);

    Route::get('/{uuid}/statistics', [
        'as'   => 'character.statistics',
        'uses' => 'CharacterController@statistics'
    ]);

    Route::get('/{uuid}/about', [
        'as'   => 'character.about',
        'uses' => 'CharacterController@about'
    ]);

    Route::get('/{uuid}/about/edit', [
        'as'   => 'character.about.edit',
        'uses' => 'CharacterController@aboutEdit',
        'middleware' => 'auth'
    ]);

    Route::post('/{uuid}/about/edit', [
        'as'   => 'character.about.store',
        'uses' => 'CharacterController@aboutStore',
        'middleware' => 'auth'
    ]);
});

