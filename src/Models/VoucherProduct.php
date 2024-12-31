<?php

namespace Callmeaf\Voucher\Models;

use Callmeaf\Base\Contracts\HasMeta;
use Callmeaf\Base\Traits\HasDate;
use Callmeaf\Base\Traits\Metaable;
use Illuminate\Database\Eloquent\Relations\Pivot;

class VoucherProduct extends Pivot implements HasMeta
{
    use Metaable,HasDate;

    protected $table = 'voucher_product';

    protected $fillable = [
        'voucher_id',
        'product_id',
    ];


    public function metaData(): ?array
    {
        return null;
    }
}
