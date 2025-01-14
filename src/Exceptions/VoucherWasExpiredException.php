<?php

namespace Callmeaf\Voucher\Exceptions;

use Symfony\Component\HttpFoundation\Response;

class VoucherWasExpiredException extends \Exception
{
    public function __construct(string $message = "", int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message ?: __('callmeaf-voucher::v1.errors.was_expired'), $code ?: Response::HTTP_EXPECTATION_FAILED, $previous);
    }
}
