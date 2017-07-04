<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'vouchers';

    public $timestamps = false;

    public function products()
    {
        return $this->belongsToMany(Product::class, 'products2vouchers', 'voucher_id', 'product_id' );
    }
}
