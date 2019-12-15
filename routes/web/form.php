<?php
Route::post('/form/{id}/submit/old', [
    'as'   => 'form.submit.old',
    'uses' => 'FormController@submitOld'
]);


Route::post('/form/{id}/submit', [
    'as'   => 'form.submit',
    'uses' => 'FormController@submit'
]);