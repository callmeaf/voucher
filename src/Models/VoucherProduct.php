<?php

namespace Callmeaf\Voucher\Models;

use Callmeaf\Base\Traits\HasDate;
use Callmeaf\Base\Traits\Metaable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

class VoucherProduct extends Pivot
{
    use Metaable,HasDate;

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = true;

    protected $table = 'voucher_product';

    protected $fillable = [
        'voucher_id',
        'product_id',
    ];


    public function product(): BelongsTo
    {
        return $this->belongsTo(config('callmeaf-product.model'));
    }

    public function voucher(): BelongsTo
    {
        return $this->belongsTo(config('callmeaf-voucher.model'));
    }

}
