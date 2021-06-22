<?php
Route::group(['prefix' => 'category', 'as' => 'category.', 'namespace' =>'Api'], function () {
    Route::get('/', 'CategoryController@index');
});