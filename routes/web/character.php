<?php

Route::group([
    'prefix' => 'character'
], function ($router) {

    Route::get('/{uuid}', [
        'as'   => 'character.show',
        'uses' => 'CharacterController@show'
    ]);

});

