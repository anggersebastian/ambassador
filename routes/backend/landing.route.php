<?php

Route::group(['prefix' => 'landing', 'as' => 'landing.', 'namespace' => 'Landing'], function () {
    Route::get('/', 'LandingController@indexLanding');
    Route::get('/form/{id?}', 'LandingController@formLanding');
    Route::post('/form-save/{id?}', 'LandingController@formPreSave');
    Route::get('/builder/{id?}', 'LandingController@builderLanding');
    Route::get('/preview/{id?}', 'LandingController@previewLanding');

    Route::get('/list-assets', 'LandingController@listObjectAssets');

    Route::post('/upload-asset/{id?}', 'LandingController@uploadAsset');
    Route::post('/save', 'LandingController@save');
});