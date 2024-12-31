<?php

return [
    'model' => \Callmeaf\Voucher\Models\Voucher::class,
    'model_resource' => \Callmeaf\Voucher\Http\Resources\V1\Api\VoucherResource::class,
    'model_resource_collection' => \Callmeaf\Voucher\Http\Resources\V1\Api\VoucherCollection::class,
    'service' => \Callmeaf\Voucher\Services\V1\VoucherService::class,
    'default_values' => [
        'status' => \Callmeaf\Voucher\Enums\VoucherStatus::ACTIVE,
        'type' => \Callmeaf\Voucher\Enums\VoucherType::IS_FIXED,
    ],
    'events' => [
        \Callmeaf\Voucher\Events\VoucherIndexed::class => [
            // listeners
        ],
        \Callmeaf\Voucher\Events\VoucherStored::class => [
            \Callmeaf\Voucher\Listeners\SyncProductsIdsToVoucher::class,
        ],
        \Callmeaf\Voucher\Events\VoucherShowed::class => [
            // listeners
        ],
        \Callmeaf\Voucher\Events\VoucherUpdated::class => [
            \Callmeaf\Voucher\Listeners\SyncProductsIdsToVoucher::class,
        ],
        \Callmeaf\Voucher\Events\VoucherStatusUpdated::class => [
            // listeners
        ],
        \Callmeaf\Voucher\Events\VoucherDestroyed::class => [
            // listeners
        ],
    ],
    'validations' => [
        'voucher' => \Callmeaf\Voucher\Utilities\V1\Api\Voucher\VoucherFormRequestValidator::class,
    ],
    'resources' => [
        'voucher' => \Callmeaf\Voucher\Utilities\V1\Api\Voucher\VoucherResources::class,
    ],
    'controllers' => [
        'vouchers' => \Callmeaf\Voucher\Http\Controllers\V1\Api\VoucherController::class,
    ],
    'form_request_authorizers' => [
        'voucher' => \Callmeaf\Voucher\Utilities\V1\Api\Voucher\VoucherFormRequestAuthorizer::class,
    ],
    'middlewares' => [
        'voucher' => \Callmeaf\Voucher\Utilities\V1\Api\Voucher\VoucherControllerMiddleware::class,
    ],
    'searcher' => \Callmeaf\Voucher\Utilities\V1\Api\Voucher\VoucherSearcher::class,
    'code_length' => 17,
    'prefix_code' => 'callmeaf-',
    'auto_generate_code' => true,

];
