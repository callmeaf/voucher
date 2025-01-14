<?php

namespace Callmeaf\Voucher\Http\Requests\V1\Api;

use Callmeaf\Voucher\Enums\VoucherStatus;
use Callmeaf\Voucher\Enums\VoucherType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

class VoucherUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return app(config('callmeaf-voucher.form_request_authorizers.voucher'))->store();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $voucher = $this->route('voucher');
        $rules = [
            'status' => [new Enum(VoucherStatus::class)],
            'type' => [new Enum(VoucherType::class)],
            'title' => ['string','max:255',Rule::unique(config('callmeaf-voucher.model'),'title')->ignore($voucher->id)],
            'code' => ['string','size:' . config('callmeaf-voucher.code_length'),Rule::unique(config('callmeaf-voucher.model'),'code')->ignore($voucher->id)],
            'discount_price' => ['numeric','gt:0'],
            'max_uses' => ['integer','min:0'],
            'max_uses_user' => ['integer','min:0'],
            'content' => ['string','max:700'],
            'products_ids' => ['array'],
            'products_ids.*' => [Rule::exists(config('callmeaf-product.model'),'id')],
            ...publishedAndExpiredValidationRules(),
        ];

        if(authUser(request: $this)?->isSuperAdminOrAdmin()) {
            $rules['author_id'] = [Rule::exists(config('callmeaf-user.model'),'id')];
        }

        return validationManager(rules: $rules,filters: app(config("callmeaf-voucher.validations.voucher"))->store());
    }

}
