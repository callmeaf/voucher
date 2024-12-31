<?php

namespace Callmeaf\Voucher\Models;

use Callmeaf\Base\Contracts\HasEnum;
use Callmeaf\Base\Contracts\HasResponseTitles;
use Callmeaf\Base\Enums\ResponseTitle;
use Callmeaf\Base\Traits\HasAuthor;
use Callmeaf\Base\Traits\HasDate;
use Callmeaf\Base\Traits\HasStatus;
use Callmeaf\Base\Traits\HasType;
use Callmeaf\Base\Traits\Publishable;
use Callmeaf\Product\Models\Product;
use Callmeaf\Voucher\Enums\VoucherStatus;
use Callmeaf\Voucher\Enums\VoucherType;
use Callmeaf\Voucher\Services\V1\VoucherService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Voucher extends Model implements HasResponseTitles,HasEnum
{
    use HasDate,HasStatus,HasType,Publishable,HasAuthor;
    protected $fillable = [
        'status',
        'type',
        'title',
        'code',
        'discount_amount',
        'max_uses',
        'max_uses_user',
        'content',
        'published_at',
        'expired_at',
    ];

    protected $casts = [
        'status' => VoucherStatus::class,
        'type' => VoucherType::class,
    ];

    protected static function booted()
    {
        static::creating(function(Model $model) {
            if(isEnableAutoGenerateVoucherCode()) {
                /**
                 * @var VoucherService $voucherService
                 */
                $voucherService = app(config('callmeaf-voucher.service'));
                $model->forceFill([
                    'code' => $model->code ?? $voucherService->newCode(),
                ]);
            }
        });
    }

    public function products(): BelongsToMany
    {
        /**
         * @var VoucherProduct $voucherProductModel
         */
        $voucherProductModel = config('callmeaf-voucher-product-pivot.model');
        /**
         * @var Product $productModel
         */
        $productModel = config('callmeaf-product.model');
        return $this->belongsToMany($productModel,getTableName($voucherProductModel),'voucher_id','product_id')->withTimestamps()->withPivot([
            'id'
        ])->using($voucherProductModel);
    }

    public function responseTitles(ResponseTitle|string $key,string $default = ''): string
    {
        return [
            'store' => $this?->code ?? $default,
            'update' => $this?->code ?? $default,
            'status_update' => $this?->code ?? $default,
            'destroy' => $this?->code ?? $default,
        ][$key instanceof ResponseTitle ? $key->value : $key];
    }

    public static function enumsLang(): array
    {
        return __('callmeaf-voucher::enums');
    }
}
