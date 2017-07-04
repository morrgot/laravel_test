<?php
/**
 * Created by PhpStorm.
 * User: morrgot
 * Date: 04.07.2017
 * Time: 13:01
 */

Route::group(['domain' => 'api.laravel_test.dev'], function () {
    Route::post('product/add', 'ProductController@add');
    Route::post('product/{product_id}/buy', 'ProductController@add');


    Route::post('voucher/add', 'VoucherController@add');
    Route::post('voucher/{voucher_id}/product/{product_id}', 'VoucherController@bindToProduct');
    Route::delete('voucher/{voucher_id}/product/{product_id}', 'VoucherController@removeFromProduct');
});