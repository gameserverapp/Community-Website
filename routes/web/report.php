<?php
Route::post('/report/submit', [
    'as'   => 'report.submit',
    'uses' => 'ReportController@submit'
]);