<?php

namespace Callmeaf\Voucher\Http\Controllers\V1\Api;

use Callmeaf\Base\Enums\ResponseTitle;
use Callmeaf\Base\Http\Controllers\V1\Api\ApiController;
use Callmeaf\Voucher\Events\VoucherDestroyed;
use Callmeaf\Voucher\Events\VoucherIndexed;
use Callmeaf\Voucher\Events\VoucherShowed;
use Callmeaf\Voucher\Events\VoucherStatusUpdated;
use Callmeaf\Voucher\Events\VoucherStored;
use Callmeaf\Voucher\Events\VoucherUpdated;
use Callmeaf\Voucher\Http\Requests\V1\Api\VoucherDestroyRequest;
use Callmeaf\Voucher\Http\Requests\V1\Api\VoucherIndexRequest;
use Callmeaf\Voucher\Http\Requests\V1\Api\VoucherShowRequest;
use Callmeaf\Voucher\Http\Requests\V1\Api\VoucherStatusUpdateRequest;
use Callmeaf\Voucher\Http\Requests\V1\Api\VoucherStoreRequest;
use Callmeaf\Voucher\Http\Requests\V1\Api\VoucherUpdateRequest;
use Callmeaf\Voucher\Models\Voucher;
use Callmeaf\Voucher\Services\V1\VoucherService;
use Callmeaf\Voucher\Utilities\V1\Api\Voucher\VoucherResources;

class VoucherController extends ApiController
{
    protected VoucherService $voucherService;
    protected VoucherResources $voucherResources;
    public function __construct()
    {
        $this->voucherService = app(config('callmeaf-voucher.service'));
        $this->voucherResources = app(config('callmeaf-voucher.resources.voucher'));
    }

    public static function middleware(): array
    {
        return app(config('callmeaf-voucher.middlewares.voucher'))();
    }

    public function index(VoucherIndexRequest $request)
    {
        try {
            $resources = $this->voucherResources->index();
            $vouchers = $this->voucherService->all(
                relations: $resources->relations(),
                columns: $resources->columns(),
                filters: $request->validated(),
                events: [
                    VoucherIndexed::class,
                ],
            )->getCollection(asResourceCollection: true,asResponseData: true,attributes: $resources->attributes());
            return apiResponse([
                'vouchers' => $vouchers,
            ],__('callmeaf-base::v1.successful_loaded'));
        } catch (\Exception $exception) {
            report($exception);
            return apiResponse([],$exception);
        }
    }

    public function store(VoucherStoreRequest $request)
    {
        try {
            $resources = $this->voucherResources->store();
            $voucher = $this->voucherService->create(data: $request->validated(),events: [
                VoucherStored::class
            ])->getModel(asResource: true,attributes: $resources->attributes(),relations: $resources->relations());
            return apiResponse([
                'voucher' => $voucher,
            ],__('callmeaf-base::v1.successful_created', [
                'title' => $voucher->responseTitles(ResponseTitle::STORE),
            ]));
        } catch (\Exception $exception) {
            report($exception);
            return apiResponse([],$exception);
        }
    }

    public function show(VoucherShowRequest $request,Voucher $voucher)
    {
        try {
            $resources = $this->voucherResources->show();
            $voucher = $this->voucherService->setModel($voucher)->getModel(
                asResource: true,
                attributes: $resources->attributes(),
                relations: $resources->relations(),
                events: [
                    VoucherShowed::class,
                ],
            );
            return apiResponse([
                'voucher' => $voucher,
            ],__('callmeaf-base::v1.successful_loaded'));
        } catch (\Exception $exception) {
            report($exception);
            return apiResponse([],$exception);
        }
    }

    public function update(VoucherUpdateRequest $request,Voucher $voucher)
    {
        try {
            $resources = $this->voucherResources->update();
            $voucher = $this->voucherService->setModel($voucher)->update(data: $request->validated(),events: [
                VoucherUpdated::class,
            ])->getModel(asResource: true,attributes: $resources->attributes(),relations: $resources->relations());
            return apiResponse([
                'voucher' => $voucher,
            ],__('callmeaf-base::v1.successful_updated', [
                'title' =>  $voucher->responseTitles(ResponseTitle::UPDATE)
            ]));
        } catch (\Exception $exception) {
            report($exception);
            return apiResponse([],$exception);
        }
    }

    public function statusUpdate(VoucherStatusUpdateRequest $request,Voucher $voucher)
    {
        try {
            $resources = $this->voucherResources->statusUpdate();
            $voucher = $this->voucherService->setModel($voucher)->update([
                'status' => $request->get('status'),
            ],events: [
                VoucherStatusUpdated::class,
            ])->getModel(asResource: true,attributes: $resources->attributes(),relations: $resources->relations());
            return apiResponse([
                'voucher' => $voucher,
            ],__('callmeaf-base::v1.successful_updated', [
                'title' =>  $voucher->responseTitles(ResponseTitle::STATUS_UPDATE)
            ]));
        } catch (\Exception $exception) {
            report($exception);
            return apiResponse([],$exception);
        }
    }

    public function destroy(VoucherDestroyRequest $request,Voucher $voucher)
    {
        try {
            $resources = $this->voucherResources->destroy();
            $voucher = $this->voucherService->setModel($voucher)->delete(events: [
                VoucherDestroyed::class,
            ])->getModel(asResource: true,attributes: $resources->attributes(),relations: $resources->relations());
            return apiResponse([
                'voucher' => $voucher,
            ],__('callmeaf-base::v1.successful_deleted', [
                'title' =>  $voucher->responseTitles(ResponseTitle::DESTROY)
            ]));
        } catch (\Exception $exception) {
            report($exception);
            return apiResponse([],$exception);
        }
    }
}
