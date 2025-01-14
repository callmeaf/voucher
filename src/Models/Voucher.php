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
use Callmeaf\Order\Enums\OrderStatus;
use Callmeaf\Order\Models\Order;
use Callmeaf\Product\Models\Product;
use Callmeaf\User\Models\User;
use Callmeaf\Voucher\Enums\VoucherStatus;
use Callmeaf\Voucher\Enums\VoucherType;
use Callmeaf\Voucher\Exceptions\VoucherAlreadyUsedInThisOrderException;
use Callmeaf\Voucher\Exceptions\VoucherCanNotApplyForNonPendingOrderException;
use Callmeaf\Voucher\Exceptions\VoucherDoesNotBelongsToThisProductsException;
use Callmeaf\Voucher\Exceptions\VoucherHasReachedMaxUsesException;
use Callmeaf\Voucher\Exceptions\VoucherHasReachedMaxUsesUserException;
use Callmeaf\Voucher\Exceptions\VoucherNotFoundException;
use Callmeaf\Voucher\Exceptions\VoucherWasExpiredException;
use Callmeaf\Voucher\Services\V1\VoucherService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Voucher extends Model implements HasResponseTitles,HasEnum
{
    use HasDate,HasStatus,HasType,Publishable,HasAuthor;
    protected $fillable = [
        'status',
        'type',
        'title',
        'code',
        'discount_price',
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

    public function discounts(): HasMany
    {
        return $this->hasMany(config('callmeaf-order-item-discount.model'));
    }

    public function canBeUsedForOrder(Order $order,?User $user = null): bool
    {
        if($this->isInActive()) {
            throw new VoucherNotFoundException();
        }

        if(! is_null($this->published_at) && now()->lessThan($this->published_at)) {
            throw new VoucherNotFoundException();
        }

        if(! is_null($this->expired_at) && now()->greaterThan($this->expired_at)) {
            throw new VoucherWasExpiredException();
        }

        if($order->status !== OrderStatus::PENDING) {
            throw new VoucherCanNotApplyForNonPendingOrderException();
        }

        $user = $user ?? $order->user;
        $discounts = $this->discounts()->with(['order','orderItem.variation'])->get();
        if($discounts->filter(fn($discount) => strval($discount->order->id) === strval($order->id))->isNotEmpty()) {
            throw new VoucherAlreadyUsedInThisOrderException();
        }
        if($discounts->count() >= $this->max_uses) {
            throw new VoucherHasReachedMaxUsesException();
        }
        if($discounts->filter(fn($discount) => strval($discount->order->user_id) === strval($user->id))->count() >= $this->max_uses_user) {
            throw new VoucherHasReachedMaxUsesUserException();
        }
        $order = $order->loadMissing(['items.variation']);
        if($order->items->pluck('variation.product_id')->unique()->intersect($this->products()->pluck('product_id'))->isEmpty()) {
            throw new VoucherDoesNotBelongsToThisProductsException();
        }


        return true;
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
