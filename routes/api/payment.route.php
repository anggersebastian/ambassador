<?php
Route::group(['prefix' => 'payment', 'namespace' =>'Api'], function () {
    Route::post('/midtrans', 'MidtransController@snap');
    Route::post('/midtrans/save-info', 'MidtransController@saveInfo');
    Route::post('/midtrans/notification', 'MidtransController@notification');
    Route::post('/midtrans/importir-notification', 'MidtransController@importirNotif');
});