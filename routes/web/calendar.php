<?php

Route::group([
    'prefix' => 'calendar'
], function ($router) {

    Route::get('/', [
        'as'   => 'calendar.index',
        'uses' => 'CalendarController@index'
    ]);

    Route::get('/feed', [
        'as'   => 'calendar.feed',
        'uses' => 'CalendarController@feed'
    ]);

    Route::get('/{id}-{slug}', [
        'as'   => 'calendar.show',
        'uses' => 'CalendarController@show'
    ]);

    Route::post('/{id}/participate', [
        'as'   => 'calendar.participate',
        'uses' => 'CalendarController@participate',
        'middleware' => 'auth'
    ]);

});

