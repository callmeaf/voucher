<?php

namespace Callmeaf\Voucher\Events;

use Callmeaf\Voucher\Models\Voucher;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class VoucherDestroyed
{
    use Dispatchable, SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct(public Voucher $voucher)
    {

    }
}
