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
        'uses' => 'CalendarController@show',
        'middleware' => 'valid_id_slug'
    ]);

    Route::post('/{id}/participate', [
        'as'   => 'calendar.participate',
        'uses' => 'CalendarController@participate',
        'middleware' => ['auth', 'valid_id_slug']
    ]);


    Route::get('{id}-{slug}/purge_cache', [
        'as'   => 'calendar.purge',
        'uses' => 'CalendarController@purge',
        'middleware' => 'valid_id_slug'
    ]);
});

