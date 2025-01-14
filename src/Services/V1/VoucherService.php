<?php

namespace Callmeaf\Voucher\Services\V1;

use Callmeaf\Base\Services\V1\BaseService;
use Callmeaf\Voucher\Exceptions\VoucherAutoGenerateCodeDisabledException;
use Callmeaf\Product\Models\Product;
use Callmeaf\Voucher\Services\V1\Contracts\VoucherServiceInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Str;

class VoucherService extends BaseService implements VoucherServiceInterface
{
    public function __construct(?Builder $query = null, ?Model $model = null, ?Collection $collection = null, ?JsonResource $resource = null, ?ResourceCollection $resourceCollection = null, array $defaultData = [],?string $searcher = null)
    {
        parent::__construct($query, $model, $collection, $resource, $resourceCollection, $defaultData,$searcher);
        $this->query = app(config('callmeaf-voucher.model'))->query();
        $this->resource = config('callmeaf-voucher.model_resource');
        $this->resourceCollection = config('callmeaf-voucher.model_resource_collection');
        $this->defaultData = config('callmeaf-voucher.default_values');
        $this->searcher = config('callmeaf-voucher.searcher');
    }

    public function newCode(): string
    {
        $code = $this->generateUniqueCode();
        while ($this->freshQuery()->where(column: 'code',valueOrOperation: $code)->exists()) {
            $code = $this->generateUniqueCode();
        }
        return $code;
    }

    public function syncProducts(array|int|string|Product|null $productIds): VoucherServiceInterface
    {
        $productIds = collect($productIds ?? []);
        /**
         * @var Product $productModel
         */
        $productModel = config('callmeaf-product.model');
        foreach ($productIds->filter(fn($item) => $item instanceof $productModel)->values() as $index => $product) {
            $productIds->replace([$index => $product->id]);
        }

        $this->model->products()->sync($productIds);
        return $this;
    }

    private function generateUniqueCode(): string
    {
        if(! isEnableAutoGenerateVoucherCode()) {
            throw new VoucherAutoGenerateCodeDisabledException();
        }

        $prefix = config('callmeaf-voucher.prefix_code');
        $prefix_length = str($prefix)->length();
        $code_length = config('callmeaf-voucher.code_length');
        return $prefix . Str::random($code_length - $prefix_length);
    }
}
