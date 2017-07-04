<?php
/**
 * Created by PhpStorm.
 * User: morrgot
 * Date: 03.07.2017
 * Time: 15:30
 */

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use \Symfony\Component\HttpKernel\Exception as HttpException;

class ProductController extends Controller
{
    public function add()
    {
        //print_r(get_class($this->app));
        //return view('index', ['o' => 'product/addddd']);
        //throw new HttpException\BadRequestHttpException('daaad');
        $resp = ['a' => 1, 'cc' => 'aaa', 'd' => [], 'name' => 9];
        $product = \App\Product::find(1);

        foreach ($product->vouchers()->orderBy('end', 'asc')->get() as $v) {
            $resp['d'][] = $v->discount;
        }

        $resp['sum'] = $product->totalDiscount();

        var_dump($product->totalDiscount());

        return $resp;
    }
}