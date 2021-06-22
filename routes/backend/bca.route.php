<?php

Route::group(['prefix' => 'bca', 'as' => 'bca.', 'namespace' => 'Bca'], function () {
    Route::get('/', 'BcaController@index');
});
