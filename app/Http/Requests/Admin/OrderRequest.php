<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Order;

class OrderRequest extends FormRequest
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
            'number' => ['required','string','max:70'],
            'amount' => ['required','string','max:255'],
            'description' => ['required','string','max:255'],
            'user_id' => ['required','exists:users,id'],
            'status' => ['required','in:'.implode(',',Order::STATUSES)],
        ];
    }

}
