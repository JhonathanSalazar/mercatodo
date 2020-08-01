<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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


Auth::routes(['verify' => true]);

Route::get('/','Customer\PagesController@home')->name('home');

Route::get('categorias/{category}', 'Customer\CategoriesController@show')->name('pages.category.show');

Route::group(['prefix' => 'admin'],
    function() {
    Route::get('/', 'Admin\DashboardController@main')->name('admin.dashboard');

    Route::resource('users', 'Admin\UsersController',
        [
            'except' => ['create','store'],
            'as' => 'admin'
        ]);

    Route::get('products', 'Admin\ProductsController@index')->name('admin.products.index');
    Route::get('products/create', 'Admin\ProductsController@create')->name('admin.products.create');
    Route::post('products', 'Admin\ProductsController@store')->name('admin.products.store');
    Route::get('products/{product}','Admin\ProductsController@show')->name('admin.products.show');
    Route::get('products/edit/{product}','Admin\ProductsController@edit')->name('admin.products.edit');
    Route::put('products/{product}', 'Admin\ProductsController@update')->name('admin.products.update');
    Route::delete('products/{product}','Admin\ProductsController@destroy')->name('admin.products.destroy');

    });

Route::get('account/{user}','Customer\UserDataController@edit')->name('pages.user-account.edit');
Route::put('account/{user}', 'Customer\UserDataController@update')->name('pages.user-account.update');

Route::view('/product-details','product.product-details')->name('products.details');
Route::view('/product-list','product.product-list')->name('products.list');


Route::get('/your-car','Customer\PagesController@yourCar')->name('pages.your-car');
Route::get('/checkout','Customer\PagesController@checkout')->name('pages.checkout');
Route::get('/about','Customer\PagesController@aboutUs')->name('pages.about');
Route::get('/contact', 'Customer\PagesController@contactUs')->name('pages.contact');



