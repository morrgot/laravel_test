<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    protected $products = [
        ['name' => 'product1', 'price' => 100, 'active' => 1],
        ['name' => 'product2', 'votes' => 70, 'active' => 1],
        ['name' => 'product3', 'votes' => 110, 'active' => 1],
        ['name' => 'product4', 'votes' => 200, 'active' => 1],
        ['name' => 'product5', 'votes' => 100, 'active' => 1]
    ];

    protected $vouchers = [
        ['start' => '2017-01-11', 'end' => '2017-08-11', 'discount' => 10, 'active' => 1],
        ['start' => '2017-04-11', 'end' => '2017-06-11', 'discount' => 15, 'active' => 1],
        ['start' => '2017-01-11', 'end' => '2017-02-11', 'discount' => 25, 'active' => 1],
        ['start' => '2017-05-11', 'end' => '2017-09-11', 'discount' => 25, 'active' => 1],
        ['start' => '2017-05-11', 'end' => '2017-10-11', 'discount' => 25, 'active' => 1],
        ['start' => '2017-10-11', 'end' => '2017-11-11', 'discount' => 20, 'active' => 1]
    ];

    protected $products2vouchers = [
        ['product_id' => 1, 'voucher_id' => 1],
        ['product_id' => 1, 'voucher_id' => 2],
        ['product_id' => 1, 'voucher_id' => 3],
        ['product_id' => 2, 'voucher_id' => 2],
        ['product_id' => 2, 'voucher_id' => 4],
        ['product_id' => 3, 'voucher_id' => 6],
        ['product_id' => 4, 'voucher_id' => 5],
        ['product_id' => 4, 'voucher_id' => 6],
        ['product_id' => 4, 'voucher_id' => 4],
        ['product_id' => 4, 'voucher_id' => 1],
        ['product_id' => 4, 'voucher_id' => 2]
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('products')->insert($this->products);
        DB::table('vouchers')->insert($this->vouchers);
        DB::table('products2vouchers')->insert($this->products2vouchers);
    }
}
