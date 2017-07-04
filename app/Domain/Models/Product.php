<?php
/**
 * Created by PhpStorm.
 * User: morrgot
 * Date: 04.07.2017
 * Time: 14:56
 */

namespace App\Domain\Models;


/**
 * Class Product
 * @package App\Domain\Models
 *
 * @property string $name
 * @property int $price
 * @property int $active
 */
class Product extends BaseModel
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'products';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function vouchers()
    {
        return $this
            ->belongsToMany(Voucher::class, 'products2vouchers', 'product_id', 'voucher_id')
            ->where('active', 1);
    }

    public function getTotalDiscount()
    {
        return min(60, $this->vouchers()->get()->sum('discount'))*0.01;
    }

    public function getDiscountPrice()
    {
        return $this->getTotalDiscount()>0 ? round($this->price*(1 - $this->getTotalDiscount()), 2) : $this->price;
    }
}