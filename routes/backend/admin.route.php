<?php
Route::group(['prefix' => 'admin'], function () {
    Route::get('/get-cs', 'AdminController@getAllCs');
});