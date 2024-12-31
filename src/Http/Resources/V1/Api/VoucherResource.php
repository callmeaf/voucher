<?php

namespace Callmeaf\Voucher\Http\Resources\V1\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VoucherResource extends JsonResource
{
    public function __construct($resource,protected array|int $only = [])
    {
        parent::__construct($resource);
    }

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return toArrayResource(data: [
            'id' => fn() => $this->id,
            'status' => fn() => $this->status,
            'status_text' => fn() => $this->statusText,
            'type' => fn() => $this->type,
            'type_text' => fn() => $this->typeText,
            'title' => fn() => $this->title,
            'code' => fn() => $this->code,
            'discount_amount' => fn() => $this->discount_amount,
            'max_uses' => fn() => $this->max_uses,
            'max_uses_user' => fn() => $this->max_uses_user,
            'content' => fn() => $this->content,
            'published_at' => fn() => $this->published_at,
            'published_at_text' => fn() => $this->publishedAtText,
            'expired_at' => fn() => $this->expired_at,
            'expired_at_text' => fn() => $this->expiredAtText,
            'created_at' => fn() => $this->created_at,
            'created_at_text' => fn() => $this->createdAtText,
            'updated_at' => fn() => $this->updated_at,
            'updated_at_text' => fn() => $this->updatedAtText,
            'author' => fn() => $this->author ? new (config('callmeaf-user.model_resource'))($this->author,only: $this->only['!author'] ?? []) : null,
            'products_ids' => fn() => $this->products()->pluck('product_id'),
            'products' => fn() => $this->products?->count() ? new (config('callmeaf-product.model_resource_collection'))($this->products,only: $this->only['!products'] ?? []) : null,
            'pivot_products' => fn() => $this->products?->count() ? new (config('callmeaf-voucher-product-pivot.model_resource_collection'))($this->products->pluck('pivot'),only: $this->only['!pivot_products'] ?? []) : null,
        ],only: $this->only);
    }
}
