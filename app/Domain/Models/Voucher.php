<?php

namespace App\Domain\Models;

class Voucher extends BaseModel
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'vouchers';

    public function products()
    {
        return $this->belongsToMany(Product::class, 'products2vouchers', 'voucher_id', 'product_id' );
    }
}
