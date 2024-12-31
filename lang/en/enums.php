<?php


use Callmeaf\Voucher\Enums\VoucherStatus;
use Callmeaf\Voucher\Enums\VoucherType;

return [
    VoucherStatus::class => [
        VoucherStatus::ACTIVE->name => 'Active',
        VoucherStatus::INACTIVE->name => 'InActive',
    ],
    VoucherType::class => [
        VoucherType::IS_FIXED->name => 'IsFixed',
        VoucherType::PERCENTAGE->name => 'Percentage'
    ],
];
