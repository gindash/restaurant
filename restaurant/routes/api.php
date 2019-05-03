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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Route::get('/test', function(Request $request){
    //     return 'ok';
    // });

Route::post('/login', 'API\AuthController@login')->name('login');

Route::group(['middleware' => ['checkuser']], function () {

        Route::post('/department', 'API\DepartmentController@store')->name('department.store');
        Route::put('/department/{id}', 'API\DepartmentController@update')->name('department.update');
        Route::get('/departments', 'API\DepartmentController@index')->name('department.index');

        Route::get('/logout', 'API\AuthController@logout')->name('logout');

        Route::post('/product', 'API\ProductController@store')->name('product.store');
        Route::put('/product/{id}', 'API\ProductController@update')->name('product.update');
        Route::get('/products', 'API\ProductController@index')->name('product.index');
        Route::get('/products-ready', 'API\ProductController@productsReady')->name('products-ready.index');

        Route::post('/user', 'API\UserController@store')->name('user.store');
});

