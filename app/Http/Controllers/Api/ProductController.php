<?php
/**
 * Created by PhpStorm.
 * User: morrgot
 * Date: 03.07.2017
 * Time: 15:30
 */

namespace App\Http\Controllers\Api;

use App\Domain\Services\ProductService;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Validation\ValidationException;
use Illuminate\Http\Request;
use App\Exceptions\ServerErrorException as ServerError;
use \Symfony\Component\HttpKernel\Exception\BadRequestHttpException as BadRequest;

class ProductController extends Controller
{
    /**
     * @var ProductService
     */
    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function add(Request $request)
    {
        try{
            $product = $this->productService->createProduct($request->all());
        } catch (ValidationException $e) {
            throw new BadRequest($e->getMessageProvider()->getMessageBag()->first());
        } catch (\RuntimeException $e) {
            throw new ServerError($e->getMessage());
        }

        return ['id' => $product->id];
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

        return ['id' => $product_id];
    }
}