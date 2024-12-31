<?php

namespace Callmeaf\Voucher\Services\V1\Contracts;

use Callmeaf\Base\Services\V1\Contracts\BaseServiceInterface;
use Callmeaf\Product\Models\Product;

interface VoucherServiceInterface extends BaseServiceInterface
{
    public function newCode(): string;

    /**
     * @param array<int, string, Product>|int|string|Product|null $productIds
     * @return self
     */
    public function syncProducts(array|int|string|Product|null $productIds): self;
}
