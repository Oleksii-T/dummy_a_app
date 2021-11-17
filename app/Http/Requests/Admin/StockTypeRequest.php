<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\RealStockType;

class StockTypeRequest extends FormRequest
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
        $model = request()->route('stock_type');
        $nameRule = 'unique:stock_types,name';
        $nameRule = $model ? "$nameRule,$model->id" : $nameRule;

        return [
            'name' => ['required','max:70',$nameRule,new RealStockType],
        ];
    }

}
