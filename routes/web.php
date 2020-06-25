<?php

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

// Authentication Routes...
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

// Registration Routes...
Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', 'Auth\RegisterController@register');

// Password Reset Routes...
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm');
Route::post('password/reset', 'Auth\ResetPasswordController@reset');


Route::view('/','home')->name('home');
Route::get('/admin', 'AdminController@main')->name('admin.dashboard');

Route::get('account','PagesController@userAccount')->name('pages.user-account');
Route::get('/your-car','PagesController@yourCar')->name('pages.your-car');
Route::get('/checkout','PagesController@checkout')->name('pages.checkout');
Route::get('/about','PagesController@aboutUs')->name('pages.about');
Route::get('/contact', 'PagesController@contactUs')->name('pages.contact');



