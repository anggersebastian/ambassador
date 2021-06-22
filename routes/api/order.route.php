<?php
Route::group(['prefix' => 'order', 'as' => 'order.', 'namespace' =>'Api'], function () {
    Route::post('/', 'OrderController@makeOrder');
    Route::get('/{invoice}/view', 'OrderController@view');
    Route::post('/confirm', 'OrderController@confirmPayment');
    Route::get('/generate-pdf/{invoice}', 'OrderController@generatePdf');
});