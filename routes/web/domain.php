<?php

Route::get('/purge_all_cache', [
    'uses' => 'HomeController@purge'
]);


Route::get('/verify/{code}', [
    'uses' => 'HomeController@verify'
]);