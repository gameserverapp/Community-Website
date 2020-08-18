<?php

Route::group([
    'prefix' => 'stat'
], function ($router) {

    Route::get('/{stat}', [
        'as'   => 'stat.index',
        'uses' => 'StatController@index'
    ]);

});

