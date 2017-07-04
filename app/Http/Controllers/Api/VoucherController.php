<?php
/**
 * Created by PhpStorm.
 * User: morrgot
 * Date: 04.07.2017
 * Time: 12:31
 */

namespace App\Http\Controllers\Api;

use App\Domain\Services\VoucherService;
use App\Exceptions\ServerErrorException;
use App\Http\Controllers\Controller;
use App\Domain\Models\Product;
use App\Domain\Models\Voucher;
use \Symfony\Component\HttpKernel\Exception as HttpException;
use Illuminate\Http\Request;
use Illuminate\Contracts\Validation\ValidationException;
use App\Exceptions\ServerErrorException as ServerError;
use \Symfony\Component\HttpKernel\Exception\BadRequestHttpException as BadRequest;

class VoucherController extends Controller
{
    /**
     * @var VoucherService
     */
    protected $voucherService;

    public function __construct(VoucherService $voucherService)
    {
        $this->voucherService = $voucherService;
    }

    public function create(Request $request)
    {
        try{
            $voucher = $this->voucherService->createVoucher($request->all());
        } catch (ValidationException $e) {
            throw new BadRequest($e->getMessageProvider()->getMessageBag()->first());
        } catch (\RuntimeException $e) {
            throw new ServerError($e->getMessage());
        }

        return ['id' => $voucher->id];
    }

    public function addToProduct($voucher_id, $product_id)
    {
        try {
            $this->voucherService->bindToProduct($voucher_id, $product_id);
        } catch (\RuntimeException $e) {
            throw new BadRequest($e->getMessage());
        }

        return response('', 200);
    }

    public function removeFromProduct($voucher_id, $product_id)
    {
        try {
            $this->voucherService->unbindFromProduct($voucher_id, $product_id);
        } catch (\RuntimeException $e) {
            throw new BadRequest($e->getMessage());
        }

        return response('', 200);
    }
}