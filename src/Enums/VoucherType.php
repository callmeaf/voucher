<?php

namespace Callmeaf\Voucher\Enums;

enum VoucherType: int
{
    case IS_FIXED = 1;
    case PERCENTAGE = 2;
}
