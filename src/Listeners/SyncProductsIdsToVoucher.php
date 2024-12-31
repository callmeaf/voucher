<?php

namespace Callmeaf\Voucher\Listeners;

use Callmeaf\Voucher\Events\VoucherStored;
use Callmeaf\Voucher\Events\VoucherUpdated;
use Callmeaf\Voucher\Services\V1\VoucherService;

class SyncProductsIdsToVoucher
{
    /**
     * Handle the event.
     *
     * @param VoucherStored|VoucherUpdated $event
     * @return void
     */
    public function handle(VoucherStored|VoucherUpdated $event)
    {
        /**
         * @var VoucherService $voucherService
         */
        $voucherService = app(config('callmeaf-voucher.service'));
        $voucherService->setModel($event->voucher)->syncProducts(productIds: request()->get('products_ids'));
    }
}
