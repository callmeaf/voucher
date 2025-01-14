<?php

namespace Callmeaf\Voucher\Exceptions;

use Symfony\Component\HttpFoundation\Response;

class VoucherDoesNotBelongsToThisProductsException extends \Exception
{
    public function __construct(string $message = "", int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message ?: __('callmeaf-voucher::v1.errors.does_not_belongs_to_this_products'), $code ?: Response::HTTP_EXPECTATION_FAILED, $previous);
    }
}
