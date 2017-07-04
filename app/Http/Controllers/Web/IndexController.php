<?php

/**
 * Created by PhpStorm.
 * User: morrgot
 * Date: 03.07.2017
 * Time: 15:39
 */

namespace App\Http\Controllers\Web;

use App\Domain\Models\Product;
use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    public function index()
    {
        $products = Product::where('active', 1)->get();

        return view('index', ['products' => $products]);
    }
}