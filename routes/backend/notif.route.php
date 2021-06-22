<?php

Route::group(['prefix' => 'notif', 'as' => '*'], function () {
    Route::get('/', 'NotifController@index');
    Route::post('/', 'NotifController@markAsReadAll');
});