<?php

namespace Callmeaf\Voucher\Utilities\V1\Api\Voucher;

use Callmeaf\Base\Utilities\V1\Contracts\SearcherInterface;
use Illuminate\Database\Eloquent\Builder;

class VoucherSearcher implements SearcherInterface
{
    public function apply(Builder $query, array $filters = []): void
    {
        $filters = collect($filters)->filter(fn($item) => strlen(trim($item)));
        if($value = $filters->get('title')) {
            $query->where('title','like',searcherLikeValue($value));
        }
        if($value = $filters->get('code')) {
            $query->where('code',$value);
        }
        if($value = $filters->get('discount_price')) {
            $query->where('discount_price',$value);
        }
    }
}
