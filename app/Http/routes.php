<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', 'Web\IndexController@index');

Route::group(['domain' => 'api.laravel_test.dev'], function () {

    Route::group(['namespace' => 'Api'], function()
    {
        // Контроллеры в пространстве имён "App\Http\Controllers\Api"
        Route::get('product/add', 'ProductController@add');
    });
});
