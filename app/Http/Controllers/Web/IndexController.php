<?php

/**
 * Created by PhpStorm.
 * User: morrgot
 * Date: 03.07.2017
 * Time: 15:39
 */

namespace App\Http\Controllers\Web;

use App\Domain\Models\Product;
use App\Domain\Services\ProductService;
use App\Exceptions\ServerErrorException as ServerError;
use App\Http\Controllers\Controller;
use \Symfony\Component\HttpKernel\Exception\BadRequestHttpException as BadRequest;

class IndexController extends Controller
{
    /**
     * @var ProductService
     */
    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function index()
    {
        $products = Product::where('active', 1)->get();

        return view('index', ['products' => $products]);
    }

    public function buy($product_id)
    {
        try{
            $this->productService->buyProduct($product_id);
        } catch (\InvalidArgumentException $e) {
            throw new BadRequest($e->getMessage());
        } catch (\RuntimeException $e) {
            throw new ServerError($e->getMessage());
        }

        return ['status' => 'ok'];
    }
}