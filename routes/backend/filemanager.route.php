<?php
Route::group(['prefix' => 'filemanager', 'as' => 'filemanager.'], function () {
    Route::get('/', 'FilemanagerController@index');
    Route::post('/', 'FilemanagerController@upload');
});