<?php
Route::get('/', [
    'as'   => 'home.index',
    'uses' => 'HomeController@index'
]);

Route::get('/page/{id}-{slug}', [
    'as'   => 'page.index',
    'uses' => 'PageController@show',
    'middleware' => 'valid_id_slug'
]);

Route::get('/page/{id}-{slug}/purge_cache', [
    'as'   => 'page.purge',
    'uses' => 'PageController@purge',
    'middleware' => 'valid_id_slug'
]);