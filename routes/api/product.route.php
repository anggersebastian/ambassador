<?php
Route::group(['prefix' => 'product', 'as' => 'product.', 'namespace' =>'Api'], function () {
    Route::get('/{slug}', 'ProductController@view');
});