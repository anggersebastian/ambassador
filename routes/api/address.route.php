<?php
Route::group(['prefix' => 'address', 'as' => 'address.'], function () {
    Route::get('/', 'AddressController@index');
    Route::get('/cost', 'AddressController@ongkir');
    Route::get('/province', 'AddressController@province');
    Route::get('/city/{province}/province', 'AddressController@city');
    Route::get('/district/{city}/city', 'AddressController@district');
});