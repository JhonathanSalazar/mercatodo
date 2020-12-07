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

Route::get('/', 'Customer\PagesController@home')->name('home');

Route::get('search', 'Page\SearchController@index')->name('pages.search.index');
Route::get('tags/{tag}', 'Product\TagsController@show')->name('pages.tag.show');
Route::get('categories/{category}', 'Product\CategoriesController@show')->name('pages.category.show');
Route::get('products/{product}', 'Product\DetailsController@show')->name('products.details');

Route::group(['prefix' => 'admin'],
    function () {
        Route::get('/', 'Admin\DashboardController@main')->name('admin.dashboard');

        Route::resource('users', 'Admin\UsersController',
            [
                'except' => ['create', 'store'],
                'as' => 'admin'
            ]);

        Route::put('users/{user}/roles', 'Admin\UsersRolesController@update')->name('admin.users.roles.update');

        Route::get('products', 'Admin\ProductsController@index')->name('admin.products.index');
        Route::get('products/create', 'Admin\ProductsController@create')->name('admin.products.create');
        Route::get('products/export', 'Admin\ProductsExportController@export')->name('admin.products.export');
        Route::post('products/import', 'Admin\ProductsImportController@import')->name('admin.products.import');
        Route::post('products', 'Admin\ProductsController@store')->name('admin.products.store');
        Route::get('products/{product}', 'Admin\ProductsController@show')->name('admin.products.show');
        Route::get('products/edit/{product}', 'Admin\ProductsController@edit')->name('admin.products.edit');
        Route::put('products/{product}', 'Admin\ProductsController@update')->name('admin.products.update');
        Route::delete('products/{product}', 'Admin\ProductsController@destroy')->name('admin.products.destroy');

        Route::get('notifications', 'Admin\NotificationsController@index')->name('admin.notification.index');
        Route::patch('notifications/{notification}', 'Admin\NotificationsController@read')->name('admin.notification.read');

        Route::get('reports', 'Admin\ReportsController@index')->name('admin.reports.index');
        Route::get('reports/download/{report}', 'Admin\ReportsController@download')->name('admin.reports.download');
        Route::delete('reports/download/{report}', 'Admin\ReportsController@destroy')->name('admin.reports.destroy');

    });

Route::get('accounts/{user}', 'Customer\UserDataController@edit')->name('pages.user-account.edit');
Route::put('accounts/{user}', 'Customer\UserDataController@update')->name('pages.user-account.update');

Route::get('cart', 'Shopping\CartController@index')->name('cart.index');
Route::post('cart/add/{product}', 'Shopping\CartController@add')->name('cart.add');
Route::put('cart/{product}', 'Shopping\CartController@update')->name('cart.update');
Route::delete('cart/delete/{product}', 'Shopping\CartController@delete')->name('cart.delete');

Route::get('orders/create', 'Shopping\OrderController@create')->name('orders.create');
Route::post('orders/store', 'Shopping\OrderController@store')->name('orders.store');
Route::get('orders/index/{user}', 'Shopping\OrderController@index')->name('orders.index');
Route::get('orders/{order}', 'Shopping\OrderController@show')->name('orders.show');
Route::get('orders/edit/{order}', 'Shopping\OrderController@edit')->name('orders.edit');
Route::put('orders/update/{order}', 'Shopping\OrderController@update')->name('orders.update');
Route::delete('orders/delete/{order}', 'Shopping\OrderController@destroy')->name('orders.delete');

Route::get('orders/pay/{order}', 'Shopping\PaymentAttemptController@store')->name('payments.store');
Route::get('orders/pay/show/{order}', 'Shopping\PaymentAttemptController@show')->name('payments.show');

Route::get('/checkout', 'Customer\PagesController@checkout')->name('pages.checkout');
Route::get('/about', 'Customer\PagesController@aboutUs')->name('pages.about');
Route::get('/contact', 'Customer\PagesController@contactUs')->name('pages.contact');



