<?php

namespace Callmeaf\Voucher\Http\Resources\V1\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class VoucherCollection extends ResourceCollection
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
            'data' => $this->collection->map(fn($voucher) => toArrayResource(data: [
                'id' => fn() => $voucher->id,
                'status' => fn() => $voucher->status,
                'status_text' => fn() => $voucher->statusText,
                'type' => fn() => $voucher->type,
                'type_text' => fn() => $voucher->typeText,
                'title' => fn() => $voucher->title,
                'code' => fn() => $voucher->code,
                'discount_amount' => fn() => $voucher->discount_amount,
                'max_uses' => fn() => $voucher->max_uses,
                'max_uses_user' => fn() => $voucher->max_uses_user,
                'content' => fn() => $voucher->content,
                'published_at' => fn() => $voucher->published_at,
                'published_at_text' => fn() => $voucher->publishedAtText,
                'expired_at' => fn() => $voucher->expired_at,
                'expired_at_text' => fn() => $voucher->expiredAtText,
                'created_at' => fn() => $voucher->created_at,
                'created_at_text' => fn() => $voucher->createdAtText,
                'updated_at' => fn() => $voucher->updated_at,
                'updated_at_text' => fn() => $voucher->updatedAtText,
                'author' => fn() => $voucher->author ? new (config('callmeaf-user.model_resource'))($voucher->author,only: $this->only['!author'] ?? []) : null,
                'products_ids' => fn() => $voucher->products()->pluck('product_id'),
                'products' => fn() => $voucher->products?->count() ? new (config('callmeaf-product.model_resource_collection'))($voucher->products,only: $this->only['!products'] ?? []) : null,
                'pivot_products' => fn() => $voucher->products?->count() ? new (config('callmeaf-voucher-product-pivot.model_resource_collection'))($voucher->products->pluck('pivot'),only: $this->only['!pivot_products'] ?? []) : null,
            ],only: $this->only)),
        ];
    }
}
