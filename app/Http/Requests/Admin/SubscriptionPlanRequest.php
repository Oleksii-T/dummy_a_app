<?php

namespace App\Http\Requests\Admin;

use App\Models\SubscriptionPlan;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SubscriptionPlanRequest extends FormRequest
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
        $model = request()->route('subscription_plan');
        if ($model) {
            return [
                'popular' => ['required', 'integer', Rule::in([1, 0])],
                'features' => ['nullable', 'array']
            ];
        }
        return [
            'title' => ['required', 'max:255', 'string'],
            'description' => ['nullable', 'max:4096', 'string'],
            'price' => ['required', 'numeric', 'max:9999999.99', function($attribute, $value, $fail) {
                $isFree = (bool)request()->free_plan;
                if (!$isFree && !$value) {
                    $fail('Price can not be 0 for non trial plans');
                }
            }],
            'interval' => ['required', Rule::in(SubscriptionPlan::INTERVALS)],
            'number_intervals' => ['required_unless:interval,endless', 'integer', 'min:1', 'max:52', function($attribute, $value, $fail) {
                $interval = request()->interval;
                if (
                    ($interval=='day' && $value > 30) || 
                    ($interval=='week' && $value > 52) || 
                    ($interval=='month' && $value > 12) ||
                    ($interval=='year' && $value > 1)
                ) {
                    $fail('Invalid interval number');
                }
            }],
            'free_plan' => ['required', 'integer', Rule::in([1, 0]), function($attribute, $value, $fail) {
                if ($value==1 && SubscriptionPlan::where('free_plan', 1)->count()) {
                    $fail('Only one Trial Plan is allowed');
                }
            }],
            'popular' => ['required', 'integer', Rule::in([1, 0])],
            'features' => ['nullable', 'array'],
        ];
    }

}
