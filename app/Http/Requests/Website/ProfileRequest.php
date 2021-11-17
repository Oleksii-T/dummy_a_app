<?php

namespace App\Http\Requests\Website;

use Illuminate\Foundation\Http\FormRequest;
use Laravel\Fortify\Rules\Password;

class ProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
		return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'first_name' => ['required','string','max:70'],
            'last_name' => ['required','string','max:70'],
            'username' => ['required','string','max:70'],
            'email' => ['required','string','email','max:255','unique:users,email,'.auth()->id()],
            'password' => ['nullable', 'string', new Password, 'confirmed'] 
        ];
    }

}
