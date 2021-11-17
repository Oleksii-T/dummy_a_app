<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\NotEmptySummernote;
use App\Models\Promocode;

class SettingPaymentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
		return (auth()->check() && auth()->user()->hasRole('admin'));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'stripe_secret_key' => ['required','string','max:255'],
            'stripe_publishable_key' => ['required','string','max:255'],
            'stripe_product' => ['nullable','string','max:255'],
            'paypal_client_id' => ['nullable','string','max:255'],
            'paypal_client_secret' => ['nullable','string','max:255']
        ];
    }
}
