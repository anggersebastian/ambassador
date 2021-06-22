<?php

Route::group(['prefix' => 'tag', 'as' => 'tag'], function () {
    Route::get('/', 'TagController@index');
    Route::post('/store', 'TagController@store');
    Route::get('/edit/{id}', 'TagController@edit');
    Route::put('/update/{id}', 'TagController@update');
    Route::delete('/delete/{id}', 'TagController@destroy');
});