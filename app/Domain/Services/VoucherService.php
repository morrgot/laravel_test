<?php
/**
 * Created by PhpStorm.
 * User: morrgot
 * Date: 05.07.2017
 * Time: 0:12
 */

namespace App\Domain\Services;


use App\Domain\Models\Product;
use App\Domain\Models\Voucher;
use Illuminate\Contracts\Validation\ValidationException;

class VoucherService
{
    /**
     * @param array $data
     * @return Voucher
     *
     * @throws ValidationException|\RuntimeException
     */
    public function createVoucher(array $data)
    {
        $discounts = implode(',', Voucher::$discounts);

        /** @var \Illuminate\Validation\Validator $validator */
        $validator = \Validator::make($data, [
            'start_date' => 'bail|required|date_format:Y-m-d',
            'end_date' => 'bail|required|date_format:Y-m-d',
            'discount' => 'bail|required|in:'.$discounts
        ],[
            'discount.in' => 'The selected discount must be in range of ['.$discounts.']',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator->getMessageBag());
        }

        $voucher = new Voucher();

        $voucher->start = $data['start_date'];
        $voucher->end = $data['end_date'];
        $voucher->discount = $data['discount'];
        $voucher->active = 1;

        if(!$voucher->save()) {
            throw new \RuntimeException('Failed to save voucher');
        }

        return $voucher;
    }

    /**
     * @param int $voucher_id
     * @param int $product_id
     * @return bool
     *
     * @throws \RuntimeException
     */
    public function bindToProduct($voucher_id, $product_id)
    {
        $product = $this->validateProduct($product_id);
        $voucher = $this->validateVoucher($voucher_id, true);

        if($product->vouchers()->where('id', $voucher_id)->get()->count() > 0) {
            throw new \RuntimeException('Voucher '.$voucher_id.' already exists for product '.$product_id);
        }

        $product->vouchers()->attach($voucher_id);

        return true;
    }

    /**
     * @param int $voucher_id
     * @param int $product_id
     * @return bool
     *
     * @throws \RuntimeException
     */
    public function unbindFromProduct($voucher_id, $product_id)
    {
        $product = $this->validateProduct($product_id);
        $voucher = $this->validateVoucher($voucher_id);

        if($product->vouchers()->where('id', $voucher_id)->get()->count() < 1) {
            throw new \RuntimeException('Voucher '.$voucher_id.' does not exists for product '.$product_id);
        }

        $product->vouchers()->detach($voucher_id);

        return true;
    }

    /**
     * @param int $product_id
     * @return Product
     *
     * @throws \RuntimeException
     */
    protected function validateProduct($product_id)
    {
        if(!$product = Product::find($product_id)) {
            throw new \RuntimeException('Product '.$product_id.' not found');
        }

        if(!$product->active) {
            throw new \RuntimeException('Product '.$product_id.' is not active');
        }

        return $product;
    }


    /**
     * @param int $voucher_id
     * @param bool $check_active
     * @return Voucher
     *
     * @throws \RuntimeException
     */
    protected function validateVoucher($voucher_id, $check_active = false)
    {
        if(!$voucher = Voucher::find($voucher_id)){
            throw new \RuntimeException('Voucher '.$voucher_id.' not found');
        }

        if($check_active && !$voucher->active) {
            throw new \RuntimeException('Voucher '.$voucher_id.' is not active');
        }

        return $voucher;
    }
}