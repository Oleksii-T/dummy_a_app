<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StripeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'paymentMethodId' => ['required', 'string'],
            'subscriptionPlanId' => ['required', 'integer', Rule::exists('subscription_plans', 'id')],
            'saveMethod' => ['nullable'],
            'promocode' => ['nullable']
        ];
    }
}
