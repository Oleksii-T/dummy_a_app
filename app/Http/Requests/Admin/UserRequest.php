<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Role;

class UserRequest extends FormRequest
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
        $model = request()->route('user');
        $emailRule = 'unique:users,email';
        if ($model) {
            $emailRule .= ',' . request()->route('user')->id;
        }
        return [
            'first_name' => 'required|string|max:70',
            'last_name' => 'required|string|max:70',
            'username' => 'required|string|max:70',
            'email' => 'required|email|max:255|'.$emailRule,
            'roles' => 'required',
            'roles.*' => 'required|in:'.Role::pluck('id')->implode(','),
            'image' => 'file|nullable'
        ];
    }
}
