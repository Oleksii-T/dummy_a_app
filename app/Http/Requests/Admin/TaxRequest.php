<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class TaxRequest extends FormRequest
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
        if ($model = request()->route('tax')){
            return [
                'title' => ['required','string','max:70'],
                'is_active' => ['nullable']
            ];
        }
        return [
            'title' => ['required','string','max:70'],
            'is_active' => ['nullable'],
            'is_inclusive' => ['nullable'],
            'percentage' => ['required','integer', 'min:0', 'max:100']
        ];
    }

}
