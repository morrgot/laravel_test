<?php
/**
 * Created by PhpStorm.
 * User: morrgot
 * Date: 04.07.2017
 * Time: 13:01
 */

Route::group(['domain' => 'api.laravel_test.dev'], function () {
    Route::post('product', 'ProductController@add');
    Route::put('product/{product_id}/buy', 'ProductController@buy')
        ->where(['product_id' => '[0-9]+']);


    Route::post('voucher', 'VoucherController@add');
    Route::post('voucher/{voucher_id}/product/{product_id}', 'VoucherController@bindToProduct')
        ->where(['voucher_id' => '[0-9]+', 'product_id' => '[0-9]+']);
    Route::delete('voucher/{voucher_id}/product/{product_id}', 'VoucherController@removeFromProduct')
        ->where(['voucher_id' => '[0-9]+', 'product_id' => '[0-9]+']);
});