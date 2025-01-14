<?php

namespace Callmeaf\Voucher\Exceptions;

use Symfony\Component\HttpFoundation\Response;

class VoucherCanNotApplyOrRemoveForNonPendingOrderException extends \Exception
{
    public function __construct(string $message = "", int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message ?: __('callmeaf-voucher::v1.errors.can_not_apply_or_remove_for_non_pending_order'), $code ?: Response::HTTP_EXPECTATION_FAILED, $previous);
    }
}
