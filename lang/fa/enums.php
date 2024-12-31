<?php


use Callmeaf\Voucher\Enums\VoucherStatus;
use Callmeaf\Voucher\Enums\VoucherType;

return [
    VoucherStatus::class => [
        VoucherStatus::ACTIVE->name => 'فعال',
        VoucherStatus::INACTIVE->name => 'غیرفعال',
    ],
    VoucherType::class => [
        VoucherType::IS_FIXED->name => 'مبلغ ثابت',
        VoucherType::PERCENTAGE->name => 'درصد'
    ],
];
