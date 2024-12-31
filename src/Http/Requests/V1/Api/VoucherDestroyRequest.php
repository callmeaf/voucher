<?php

namespace Callmeaf\Voucher\Http\Requests\V1\Api;

use Illuminate\Foundation\Http\FormRequest;

class VoucherDestroyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return app(config('callmeaf-voucher.form_request_authorizers.voucher'))->destroy();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return validationManager(rules: [

        ],filters: app(config("callmeaf-voucher.validations.voucher"))->destroy());
    }

}
