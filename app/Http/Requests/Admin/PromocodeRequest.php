<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\NotEmptySummernote;
use App\Models\Promocode;

class PromocodeRequest extends FormRequest
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
        if ($model = request()->route('promocode')){
            return [
                'code' => ['required','string','max:70','unique:promocodes,code,'.$model->id]
            ];
        }
        return [
            'code' => ['required','string','max:70','unique:promocodes,code'],
            'type' => ['required', 'in:'.implode(',',Promocode::TYPES)],
            'discount' => ['required','numeric'],
            'active_from_to' => ['required','string']
        ];
    }

}
