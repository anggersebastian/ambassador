<?php
Route::group(['prefix' => 'product', 'as' => 'product.'], function () {
    Route::get('/', 'ProductController@index');
    Route::get('/json', 'ProductController@indexJson');
    Route::get('/{id}/jsonfb', 'ProductController@jsonFbReport');
    Route::get('/{id}', 'ProductController@view');
    Route::get('/{id}/view', 'ProductController@productDetails');
    Route::put('/{id}', 'ProductController@update');
Route::get('/{id}/edit', 'ProductController@edit');
    Route::post('/', 'ProductController@store');
    Route::delete('/{id}', 'ProductController@destroy');
});