<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/', function () {
    return view('website.login');
});

Route::get('/home', function () {
    return view('website.home');
});

Route::get('/myorder', function () {
    return view('website.myorder');
});

Route::get('/order', function () {
    return view('website.order');
});

Route::get('/order-detail/{id}', function () {
    return view('website.order_detail');
});


// Auth::routes();

// Route::get('/home', 'HomeController@index')->name('home');
