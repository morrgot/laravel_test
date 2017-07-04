<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Product
 * @package App
 *
 * @method static static find
 *
 * @property string $name
 */
class Product extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'products';

    public $timestamps = false;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function vouchers()
    {
        return $this
            ->belongsToMany(Voucher::class, 'products2vouchers', 'product_id', 'voucher_id')
            ->where('active', 1);
    }

    public function totalDiscount()
    {
        return min(60, $this->vouchers()->get()->sum('discount'));
    }
}
