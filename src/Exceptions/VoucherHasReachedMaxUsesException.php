<?php

namespace Callmeaf\Voucher\Exceptions;

use Symfony\Component\HttpFoundation\Response;

class VoucherHasReachedMaxUsesException extends \Exception
{
    public function __construct(string $message = "", int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message ?: __('callmeaf-voucher::v1.errors.has_reached_max_uses'), $code ?: Response::HTTP_EXPECTATION_FAILED, $previous);
    }
}
