<?php

Route::get('/purge_cache', [
    'uses' => 'HomeController@purge'
]);


Route::get('/verify/{code}', [
    'uses' => 'HomeController@verify'
]);