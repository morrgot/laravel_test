<?php
/**
 * Created by PhpStorm.
 * User: morrgot
 * Date: 04.07.2017
 * Time: 14:56
 */

namespace App\Domain\Models;

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

    public function getTotalDiscount()
    {
        return min(60, $this->vouchers()->get()->sum('discount'))*0.01;
    }

    public function getDiscountPrice()
    {
        return $this->getTotalDiscount()>0 ? round($this->price*(1 - $this->getTotalDiscount()), 2) : $this->price;
    }
}