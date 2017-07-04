<?php
/**
 * Created by PhpStorm.
 * User: morrgot
 * Date: 03.07.2017
 * Time: 15:30
 */

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Validation\ValidationException;
use Illuminate\Http\Request;
use App\Product;
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
        return ['id' => $product_id];
    }
}