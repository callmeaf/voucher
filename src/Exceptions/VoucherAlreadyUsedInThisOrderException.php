<?php

namespace Callmeaf\Voucher\Exceptions;

use Symfony\Component\HttpFoundation\Response;

class VoucherAlreadyUsedInThisOrderException extends \Exception
{
    public function __construct(string $message = "", int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message ?: __('callmeaf-voucher::v1.errors.already_used_in_this_order'), $code ?: Response::HTTP_EXPECTATION_FAILED, $previous);
    }
}
