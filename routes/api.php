<?php

use Illuminate\Http\Request;
use \App\Laravue\Faker;
use \App\Laravue\JsonResponse;

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



Route::group(['middleware' => 'api'], function () {

    Route::group(['middleware' => 'auth:api'], function () {

    Route::get('auth/user', 'AuthController@user');
    Route::post('auth/logout', 'AuthController@logout');

    Route::resource('brand', 'Api\V1\BrandController')->except([
        'edit'
    ]);

    Route::resource('color', 'Api\V1\ColorController')->except([
        'edit'
    ]);

    Route::resource('category', 'Api\V1\CategoryController')->except([
                 'edit'
    ]);

    Route::resource('event', 'Api\V1\EventController')->except([
                 'edit'
    ]);

    Route::resource('fabric-age', 'Api\V1\FabricAgeController')->except([
        'edit'
    ]);

    Route::get('product_count', 'Api\V1\ProductController@itemCount');
    Route::resource('product', 'Api\V1\ProductController')->except([
        'edit'
    ]);

    Route::get('order/validate-order-date', 'Api\V1\OrderController@validateOrderDate');
    Route::get('order_count', 'Api\V1\OrderController@itemCount');
    Route::resource('order', 'Api\V1\OrderController')->except([
        'edit', 'show'
    ]);

    Route::resource('role', 'Api\V1\RoleController')->except([
             'edit'
    ]);

    Route::resource('size', 'Api\V1\SizeController')->except([
        'edit'
    ]);

    Route::resource('user', 'Api\V1\UserController')->except([
        'edit'
    ]);

    Route::resource('user-address', 'Api\V1\UserAddressController')->except([
        'edit'
    ]);

    });

    /* Routes without Authentication */

    Route::get('brand', 'Api\V1\BrandController@index');

    Route::get('category', 'Api\V1\CategoryController@index');

    Route::get('event', 'Api\V1\EventController@index');

    Route::get('fabric-age', 'Api\V1\FabricAgeController@index');

    Route::get('product/{product}', 'Api\V1\ProductController@show');
    
    Route::get('size', 'Api\V1\SizeController@index');
    

    Route::get('color', 'Api\V1\ColorController@index');


    Route::post('auth/sign-in', 'Api\V1\UserController@signIn')->name("user.sign_in");



    Route::post('auth/login', 'AuthController@login');

    Route::resource('city', 'Api\V1\CityController')->except([
        'edit'
    ]);
    
    Route::resource('contact-us', 'Api\V1\ContactUsController')->except([
        'edit'
    ]);



    Route::get('product', 'Api\V1\ProductController@index');


    Route::apiResource('users', 'UserController')->middleware('permission:' . \App\Laravue\Acl::PERMISSION_USER_MANAGE);

    Route::get('users/{user}/permissions', 'UserController@permissions')->middleware('permission:' . \App\Laravue\Acl::PERMISSION_PERMISSION_MANAGE);

    Route::get('user_count', 'Api\V1\UserController@itemCount');

    Route::put('users/{user}/permissions', 'UserController@updatePermissions')->middleware('permission:' . \App\Laravue\Acl::PERMISSION_PERMISSION_MANAGE);

    Route::post('file/upload', 'Api\V1\FileUploadController@upload')->name("file.upload");
    Route::post('file/remove', 'Api\V1\FileUploadController@remove')->name("file.remove");


});
