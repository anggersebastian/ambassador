<?php
Route::group(['prefix' => 'category', 'as' => 'category.'], function () {
    Route::get('/', 'CategoryController@index');
    Route::get('/create', 'CategoryController@create');
    Route::post('/store', 'CategoryController@store');
    Route::get('/edit/{id}', 'CategoryController@edit');
    Route::put('/update/{id}', 'CategoryController@update');
    Route::get('/delete/{id}', 'CategoryController@delete');
});