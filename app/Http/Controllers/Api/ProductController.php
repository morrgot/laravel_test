<?php
/**
 * Created by PhpStorm.
 * User: morrgot
 * Date: 03.07.2017
 * Time: 15:30
 */

namespace App\Http\Controllers\Api;

use App\Exceptions\ServerErrorException;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Validation\ValidationException;
use Illuminate\Http\Request;
use App\Domain\Models\Product;
use \Symfony\Component\HttpKernel\Exception as HttpException;

class ProductController extends Controller
{
    public function add(Request $request)
    {
        try {
            /** @var \Illuminate\Validation\Validator $validator */
            $validator = \Validator::make($request->all(), [
                'name' => 'bail|required|max:255',
                'price' => 'required',
            ]);

            if ($validator->fails()) {
                throw new ValidationException($validator->getMessageBag());
            }

            $product = new Product();

            $product->name = $request->input('name');
            $product->price = $request->input('price');
            $product->active = 1;

            if(!$product->save()) {
                throw new HttpException\HttpException(500, 'Failed to save product');
            }

        } catch (ValidationException $e) {
            throw new HttpException\BadRequestHttpException($e->getMessageProvider()->getMessageBag()->first());
        }

        return ['id' => $product->id];
    }

    public function buy($product_id)
    {
        try {
            if(!$product = Product::find($product_id)) {
                throw new \RuntimeException('Product '.$product_id.' not found');
            }

            if(!$product->active) {
                throw new \RuntimeException('Product '.$product_id.' is not active already');
            }

            $product->active = 0;

            if(!$product->save()) {
                throw new ServerErrorException('Failed to save product');
            }

            $vouchers = $product->vouchers()->get();

            foreach ($vouchers as $voucher) {
                $voucher->active = 0;

                if(!$voucher->save()) {
                    throw new ServerErrorException('Failed to update voucher');
                }
            }

        } catch (\RuntimeException $e) {
            throw new HttpException\BadRequestHttpException($e->getMessage());
        }

        return ['id' => $product_id];
    }
}