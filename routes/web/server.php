<?php

Route::group([
    'prefix' => 'server'
], function ($router) {

    Route::get('/{id}', [
        'as'   => 'server.show',
        'uses' => 'ServerController@show'
    ]);

    Route::post('/{id}/claim-vote', [
        'as'   => 'server.claim-vote',
        'uses' => 'ServerController@claimVote'
    ]);

});

