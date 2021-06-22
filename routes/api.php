<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::group(['middleware'  => ['user']], function () {
    Route::get('/configuration/{id?}', 'Api\MasterApiController@findConfiguration');
    Route::get('/content-base', 'Api\MasterApiController@contentList');
    Route::get('/content-base/{id?}', 'Api\MasterApiController@contentDetail');
    Route::get('/maps', 'Api\MasterApiController@mapList');
    Route::get('/galleries', 'Api\MasterApiController@galleryList');
    Route::get('/partners', 'Api\MasterApiController@partnersList');

    Route::get('/news-categories', 'Api\MasterApiController@newsCategories');
    Route::get('/news', 'Api\MasterApiController@newsList');

    Route::get('/communities', 'Api\MasterApiController@communityList');

    Route::get('/about', 'Api\MasterApiController@about');
    Route::get('/about-partners', 'Api\MasterApiController@aboutPartners');
    Route::get('/about-galleries', 'Api\MasterApiController@aboutGalleries');
    Route::get('/about-maps', 'Api\MasterApiController@aboutMaps');

    Route::get('/tenant/detail/{id?}', 'Api\MasterApiController@tenantDetail');
    Route::get('/tenant-products', 'Api\MasterApiController@tenantProducts');
    Route::get('/tenant-product/detail/{id?}', 'Api\MasterApiController@tenantProductDetail');
    Route::get('/tenants', 'Api\MasterApiController@tenants');

    Route::get('/tenant/qr/{id?}', 'Api\MasterApiController@tenantQr');
    Route::get('/tenant-product/qr/{id?}', 'Api\MasterApiController@tenantProductQr');

    Route::get('/events', 'Api\MasterApiController@events');
    Route::get('/event/detail/{id?}', 'Api\MasterApiController@eventDetail');
    Route::get('/event/qr/{id?}', 'Api\MasterApiController@eventQr');

});

Route::group(['middleware'  => ['must_login_user']], function () {
    //profile-ticket/detail
    Route::any('/change-profile-post', 'Api\MasterApiController@changeProfilePost');
    Route::any('/change-profile-password-post', 'Api\MasterApiController@changeProfilePasswordPost');
    Route::any('/register-event/{id?}', 'Api\MasterApiController@registerEvent');

    Route::get('/event/profile-tickets', 'Api\MasterApiController@eventProfileTickets');
    Route::get('/event/profile-ticket/detail/{id?}', 'Api\MasterApiController@eventProfileTicketDetail');
    Route::get('/event/profile-ticket/qr/{id?}', 'Api\MasterApiController@eventProfileTicketQr');
    Route::post('/event/register-ticket/{id?}', 'Api\MasterApiController@eventRegisterPost');
    Route::post('/contact-us', 'Api\MasterApiController@contactUs');

});

Route::group(['middleware'  => ['must_not_login_user']], function () {
    Route::any('/login-post', 'Api\MasterApiController@loginPost');
    Route::any('/register-post', 'Api\MasterApiController@registerPost');

    Route::any('/forgot-post', 'Api\MasterApiController@forgotPost');
    Route::any('/forgot-code-post', 'Api\MasterApiController@forgotCodePost');
    Route::any('/forgot-password-post', 'Api\MasterApiController@forgotPasswordPost');
});

foreach (glob("../routes/api/*.route.php") as $filename) {
    include $filename;
}
Route::any('/ninja-webhook', 'Backend\Logistic\LogisticController@webhookNinja');