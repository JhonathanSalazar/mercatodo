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

Route::view('/','home')->name('home');

Route::group([
    'prefix' => 'admin',
    'middleware' => 'role:Admin'],
    function() {
    Route::get('/', 'AdminController@main')->name('admin.dashboard');
    Route::resource('users', 'Admin\UsersController',
        [
            'except' => ['create','store', 'destroy'],
            'as' => 'admin'
        ]);
});

Route::get('account','PagesController@userAccount')
    ->middleware('auth', 'verified')
    ->name('pages.user-account');


Route::get('/your-car','PagesController@yourCar')->name('pages.your-car');
Route::get('/checkout','PagesController@checkout')->name('pages.checkout');
Route::get('/about','PagesController@aboutUs')->name('pages.about');
Route::get('/contact', 'PagesController@contactUs')->name('pages.contact');



