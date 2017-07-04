<?php

/**
 * Created by PhpStorm.
 * User: morrgot
 * Date: 04.07.2017
 * Time: 22:53
 */

namespace App\Domain\Services;

use App\Domain\Models\Product;
use Illuminate\Contracts\Validation\ValidationException;


class ProductService
{
    /**
     * @param array $data
     * @return Product
     *
     * @throws ValidationException|\RuntimeException
     */
    public function createProduct(array $data)
    {
        /** @var \Illuminate\Validation\Validator $validator */
        $validator = \Validator::make($data, [
            'name' => 'bail|required|max:255    ',
            'price' => 'required|integer',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator->getMessageBag());
        }

        $product = new Product();

        $product->name = $data['name'];
        $product->price = $data['price'];
        $product->active = 1;

        if(!$product->save()) {
            throw new \RuntimeException('Failed to save product');
        }

        return $product;
    }

    /**
     * @param $product_id
     * @return Product
     *
     * @throws \RuntimeException|\RuntimeException
     */
    public function buyProduct($product_id)
    {
        if(!$product = Product::find($product_id)) {
            throw new \InvalidArgumentException('Product '.$product_id.' not found');
        }

        if(!$product->active) {
            throw new \InvalidArgumentException('Product '.$product_id.' is not active already');
        }

        $product->active = 0;

        if(!$product->save()) {
            throw new \RuntimeException('Failed to save product');
        }

        $vouchers = $product->vouchers()->get();

        foreach ($vouchers as $voucher) {
            $voucher->active = 0;

            if(!$voucher->save()) {
                throw new \RuntimeException('Failed to update voucher');
            }
        }

        return $product;
    }
}