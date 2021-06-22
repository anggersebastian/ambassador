<?php
Route::group(['prefix' => 'tag', 'as' => 'tag.', 'namespace' =>'Api'], function () {
    Route::get('/', 'TagController@index');
});