<?php
Route::post('/form/{id}/submit', [
    'as'   => 'form.submit',
    'uses' => 'FormController@submit',
    'middleware' => 'valid_id_slug'
]);