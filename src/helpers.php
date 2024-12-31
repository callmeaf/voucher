<?php

if(!function_exists('isEnableAutoGenerateVoucherCode')) {
    function isEnableAutoGenerateVoucherCode(): bool
    {
        return config('callmeaf-voucher.auto_generate_code');
    }
}
