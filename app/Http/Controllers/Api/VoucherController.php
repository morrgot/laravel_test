<?php
/**
 * Created by PhpStorm.
 * User: morrgot
 * Date: 04.07.2017
 * Time: 12:31
 */

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Product;
use App\Voucher;
use Psy\Exception\RuntimeException;
use \Symfony\Component\HttpKernel\Exception as HttpException;
use Illuminate\Http\Request;
use Illuminate\Contracts\Validation\ValidationException;

class VoucherController extends Controller
{
    public function add(Request $request)
    {
        try {
            /** @var \Illuminate\Validation\Validator $validator */
            $validator = \Validator::make($request->all(), [
                'start_date' => 'bail|required|date_format:Y-m-d',
                'end_date' => 'bail|required|date_format:Y-m-d',
                'discount' => 'bail|required|in:10,15,20,25'
            ],[
                'discount.in' => 'The selected discount must be in range of [10,15,20,25]',
            ]);

            if ($validator->fails()) {
                throw new ValidationException($validator->getMessageBag());
            }

            $voucher = new Voucher();

            $voucher->start = $request->input('start_date');
            $voucher->end = $request->input('end_date');
            $voucher->discount = $request->input('discount');

            if(!$voucher->save()) {
                throw new HttpException\HttpException(500, 'Failed to save voucher');
            }

        } catch (ValidationException $e) {
            throw new HttpException\BadRequestHttpException($e->getMessageProvider()->getMessageBag()->first());
        }

        return ['id' => $voucher->id];
    }

    public function bindToProduct($voucher_id, $product_id)
    {
        try {
            if(!$voucher = Voucher::find($voucher_id)){
                throw new RuntimeException('Voucher '.$voucher_id.' not found');
            }

            if(!$voucher->active) {
                throw new RuntimeException('Voucher '.$voucher_id.' is not active');
            }

            if(!$product = Product::find($product_id)) {
                throw new RuntimeException('Product '.$product_id.' not found');
            }

            if(!$product->active) {
                throw new RuntimeException('Product '.$product_id.' is not active');
            }

            if($product->vouchers()->where('id', $voucher_id)->get()->count() > 0) {
                throw new RuntimeException('Voucher '.$voucher_id.' already exists for product '.$product_id);
            }

            $product->vouchers()->attach($voucher_id);

        } catch (\RuntimeException $e) {
            throw new HttpException\BadRequestHttpException($e->getMessage());
        }

        return response('', 200);
    }

    public function removeFromProduct($voucher_id, $product_id)
    {
        try {
            if(!$voucher = Voucher::find($voucher_id)){
                throw new RuntimeException('Voucher '.$voucher_id.' not found');
            }

            if(!$product = Product::find($product_id)) {
                throw new RuntimeException('Product '.$product_id.' not found');
            }

            if(!$product->active) {
                throw new RuntimeException('Product '.$product_id.' is not active');
            }

            if($product->vouchers()->where('id', $voucher_id)->get()->count() < 1) {
                throw new RuntimeException('Voucher '.$voucher_id.' does not exists for product '.$product_id);
            }

            $product->vouchers()->detach($voucher_id);

        } catch (\RuntimeException $e) {
            throw new HttpException\BadRequestHttpException($e->getMessage());
        }

        return response('', 200);
    }
}