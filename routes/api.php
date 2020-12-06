<?php

use CloudCreativity\LaravelJsonApi\Facades\JsonApi;

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


JsonApi::register('v1')->routes(function ($api) {
    $api->resource('products');
    $api->resource('products')->relationships(function ($api) {
        $api->hasOne('categories')->except('replace');
    });
    $api->resource('categories')->only('index', 'read');
    $api->resource('categories')->relationships(function ($api) {
        $api->hasMany('products')->except('replace', 'add', 'remove');
    });
});


