<?php

namespace Callmeaf\Voucher\Utilities\V1\Api\Voucher;

use Callmeaf\Base\Utilities\V1\FormRequestValidator;

class VoucherFormRequestValidator extends FormRequestValidator
{
    public function index(): array
    {
        return [
            'title' => false,
            'code' => false,
        ];
    }

    public function store(): array
    {
        $rules = [
            'status' => true,
            'type' => true,
            'title' => true,
            'code' => ! isEnableAutoGenerateVoucherCode(),
            'discount_price' => true,
            'max_uses' => false,
            'max_uses_user' => false,
            'content' => false,
            'published_at' => false,
            'expired_at' => false,
            'products_ids' => false,
            'products_ids.*' => false,
        ];
        if(authUser(request: $this->request)?->isSuperAdminOrAdmin()) {
            $rules['author_id'] = true;
        }

        return $rules;
    }

    public function show(): array
    {
        return [];
    }

    public function update(): array
    {
        $rules = [
            'status' => true,
            'type' => true,
            'title' => true,
            'code' => true,
            'discount_price' => true,
            'max_uses' => false,
            'max_uses_user' => false,
            'content' => false,
            'published_at' => false,
            'expired_at' => false,
            'products_ids' => false,
            'products_ids.*' => false,
        ];
        if(authUser(request: $this->request)?->isSuperAdminOrAdmin()) {
            $rules['author_id'] = true;
        }

        return $rules;
    }
    public function statusUpdate(): array
    {
        return [
            'status' => true,
        ];
    }

    public function destroy(): array
    {
        return [];
    }
}
