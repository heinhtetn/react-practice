<?php

use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\ColorController;
use App\Models\User;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['redirectIfAuth']], function () {
    Route::get('/login', 'AuthController@showLogin');
    Route::post('/login', 'AuthController@postLogin');

    Route::get('/register', 'AuthController@showRegister');
    Route::post('/register', 'AuthController@postRegister'); 
});

Route::group(['middleware' => ['redirectIfNotAuth']], function() {

    Route::get('/logout', 'AuthController@logout');
    Route::get('/profile', 'PageController@showProfile');
});


Route::get('/', 'PageController@home');
Route::get('/product', 'PageController@allProduct');
Route::get('/product/{slug}', 'ProductController@detail');


Route::get('/admin/login', 'Admin\PageController@showLogin');
Route::post('/admin/login', 'Admin\PageController@login');

Route::group(['prefix' => 'admin', 'namespace' => 'Admin', 'middleware' => ['admin']], function () {
    Route::post('/logout', 'PageController@logout');
    Route::get('/', 'PageController@showDashboard');
    Route::resource('/category', 'CategoryController');
    Route::resource('/color', 'ColorController');
    Route::resource('/brand', 'BrandController');
    Route::resource('/product', 'ProductController');
    Route::get('/create-product-add/{slug}', 'ProductController@createProductAdd');
    Route::post('/create-product-add/{slug}', 'ProductController@storeProductAdd');
    Route::get('/create-product-remove/{slug}', 'ProductController@createProductRemove');
    Route::post('/create-product-remove/{slug}', 'ProductController@storeProductRemove');
    Route::get('/add-transaction', 'ProductController@addTransaction');
    Route::get('/remove-transaction', 'ProductController@removeTransaction');
    Route::post('product-upload', 'ProductController@imageUpload');
});
