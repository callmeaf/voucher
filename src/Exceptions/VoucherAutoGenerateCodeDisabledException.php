<?php

namespace Callmeaf\Voucher\Exceptions;

use Symfony\Component\HttpFoundation\Response;

class VoucherAutoGenerateCodeDisabledException extends \Exception
{
    public function __construct(string $message = "", int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message ?: __('callmeaf-voucher::v1.errors.auto_generate_code_disabled'), $code ?: Response::HTTP_EXPECTATION_FAILED, $previous);
    }
}
