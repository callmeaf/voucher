<?php

namespace Callmeaf\Voucher\Http\Requests\V1\Api;

use Illuminate\Foundation\Http\FormRequest;

class VoucherIndexRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return app(config('callmeaf-voucher.form_request_authorizers.voucher'))->index();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return validationManager(rules: [
            'title' => [],
            'code' => [],
        ],filters: [
            ...app(config("callmeaf-voucher.validations.voucher"))->index(),
            ...config('callmeaf-base.default_searcher_validation'),
        ]);
    }

}
