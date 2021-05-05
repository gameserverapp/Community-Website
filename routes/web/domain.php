<?php

Route::get('/purge_all_cache', [
    'uses' => 'HomeController@purge'
]);


Route::get('/verify/{code}', [
    'as' => 'verify.domain',
    'uses' => 'HomeController@verify'
]);