<?php

namespace Callmeaf\Voucher\Http\Resources\V1\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class VoucherProductCollection extends ResourceCollection
{
    public function __construct($resource,protected array|int $only = [])
    {
        parent::__construct($resource);
    }

    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {

        return [
            'data' => $this->collection->map(fn($voucherProduct) => toArrayResource(data: [
                'id' => fn() => $voucherProduct->id,
                'voucher_id' => fn() => $voucherProduct->voucher_id,
                'product_id' => fn() => $voucherProduct->product_id,
                'created_at' => fn() => $voucherProduct->created_at,
                'created_at_text' => fn() => $voucherProduct->createdAtText,
                'updated_at' => fn() => $voucherProduct->updated_at,
                'updated_at_text' => fn() => $voucherProduct->updatedAtText,
            ],only: $this->only)),
        ];
    }
}
