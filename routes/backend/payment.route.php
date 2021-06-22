<?php
Route::group(['prefix' => 'payment', 'as' => '.'], function () {
    Route::get('/', 'PaymentController@index');
    Route::get('/json', 'PaymentController@indexJson');
});
