<?php

namespace App\Domain\Models;

/**
 * Class Voucher
 * @package App\Domain\Models
 *
 * @property string $start
 * @property string $end
 * @property int $discount
 * @property int $active
 */
class Voucher extends BaseModel
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'vouchers';

    public static $discounts = [10, 15, 20, 25];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'products2vouchers', 'voucher_id', 'product_id' );
    }
}
