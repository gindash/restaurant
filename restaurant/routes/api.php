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

Route::get('/test', function(){
    return 'yes';
});

Route::post('/login', 'API\AuthController@login')->name('login.store');

Route::group(['middleware' => ['auth:api', 'checkuser']], function () {
    //
    Route::get('/logout', 'API\AuthController@logout')->name('logout.store');

    Route::get('/departments', 'API\DepartmentController@index')->name('department.index');
    Route::post('/department', 'API\DepartmentController@store')->name('department.store');
    Route::put('/department/{id}', 'API\DepartmentController@update')->name('department.update');

    Route::post('/user', 'API\UserController@store')->name('user.store');
});

