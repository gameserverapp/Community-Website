<?php

Route::group([
    'prefix' => 'inspector'
], function ($router) {

    Route::get('/', [
        'as'   => 'inspector.index',
        'uses' => 'InspectorController@index'
    ]);

});

