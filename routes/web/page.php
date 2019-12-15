<?php
Route::get('/', [
    'as'   => 'home.index',
    'uses' => 'HomeController@index'
]);

Route::get('/page/{id}-{slug}', [
    'as'   => 'page.index',
    'uses' => 'PageController@show'
]);

Route::get('/page/{id}-{slug}/purge_cache', [
    'as'   => 'page.purge',
    'uses' => 'PageController@purge'
]);