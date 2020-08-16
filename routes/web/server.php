<?php

Route::group([
    'prefix' => 'server'
], function ($router) {

    Route::get('/{id}', [
        'as'   => 'server.show',
        'uses' => 'ServerController@show'
    ]);

});

