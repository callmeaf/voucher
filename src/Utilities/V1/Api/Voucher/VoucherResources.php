<?php

namespace Callmeaf\Voucher\Utilities\V1\Api\Voucher;

use Callmeaf\Base\Utilities\V1\Resources;

class VoucherResources extends Resources
{
    public function index(): self
    {
        $this->data = [
            'relations' => [
                'author'
            ],
            'columns' => [
                'id',
                'author_id',
                'type',
                'status',
                'title',
                'code',
                'discount_price',
                'max_uses',
                'max_uses_user',
                'content',
                'published_at',
                'expired_at',
                'created_at',
                'updated_at',
            ],
            'attributes' => [
                'id',
                'type',
                'type_text',
                'status',
                'status_text',
                'title',
                'code',
                'discount_price',
                'max_uses',
                'max_uses_user',
                'content',
                'published_at_text',
                'expired_at_text',
                'created_at_text',
                'updated_at_text',
            ],
        ];
        return $this;
    }

    public function store(): self
    {
        $this->data = [
            'relations' => [],
            'attributes' => [
                'id',
                'author_id',
                'type',
                'type_text',
                'status',
                'status_text',
                'title',
                'code',
                'discount_price',
                'max_uses',
                'max_uses_user',
                'content',
                'published_at_text',
                'expired_at_text',
                'created_at_text',
                'updated_at_text',
            ],
        ];
        return $this;
    }

    public function show(): self
    {
        $this->data = [
            'relations' => [
                'products'
            ],
            'attributes' => [
                'id',
                'author_id',
                'type',
                'type_text',
                'status',
                'status_text',
                'title',
                'code',
                'discount_price',
                'max_uses',
                'max_uses_user',
                'content',
                'published_at_text',
                'expired_at_text',
                'created_at_text',
                'updated_at_text',
                'products_ids',
                'pivot_products',
                '!pivot_products' => [
                    'id',
                    'product_id',
                    'created_at',
                    'created_at_text',
                    'updated_at',
                ],
            ],
        ];
        return $this;
    }

    public function update(): self
    {
        $this->data = [
            'relations' => [],
            'attributes' => [
                'id',
                'author_id',
                'type',
                'type_text',
                'status',
                'status_text',
                'title',
                'code',
                'discount_price',
                'max_uses',
                'max_uses_user',
                'content',
                'published_at_text',
                'expired_at_text',
                'created_at_text',
                'updated_at_text',
            ],
        ];
        return $this;
    }

    public function statusUpdate(): self
    {
        $this->data = [
            'relations' => [],
            'attributes' => [
                'id',
                'author_id',
                'type',
                'type_text',
                'status',
                'status_text',
                'title',
                'code',
                'discount_price',
                'max_uses',
                'max_uses_user',
                'content',
                'published_at_text',
                'expired_at_text',
                'created_at_text',
                'updated_at_text',
            ],
        ];
        return $this;
    }

    public function destroy(): self
    {
        $this->data = [
            'relations' => [],
            'attributes' => [
               'id'
            ],
        ];
        return $this;
    }
}
