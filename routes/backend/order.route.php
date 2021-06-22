<?php

Route::group(['prefix' => 'order', 'as' => 'order.'], function () {
    Route::get('/', 'OrderController@index');
    Route::get('/json', 'OrderController@indexJson');
    Route::post('/{id}/status', 'OrderController@setStatus');
    Route::post('/bulk', 'OrderController@bulkSetStatus');
    Route::put('/{id}', 'OrderController@update');
    Route::delete('/{id}', 'OrderController@destroy');
    Route::post('/follow-up/{order}', 'OrderController@setFollowUp');
});