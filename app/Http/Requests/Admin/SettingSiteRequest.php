<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class SettingSiteRequest extends FormRequest
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
            'site_logo' => ['nullable'],
            'facebook' => ['nullable','string','max:255'],
            'instagram' => ['nullable','string','max:255'],
            'twitter' => ['nullable','string','max:255'],
            'youtube' => ['nullable','string','max:255'],
            'facebook_app_id' => ['nullable','string','max:255'],
            'facebook_app_secret' => ['nullable','string','max:255'],
            'google_app_id' => ['nullable','string','max:255'],
            'google_app_secret' => ['nullable','string','max:255'],
            'twitter_app_id' => ['nullable','string','max:255'],
            'twitter_app_secret' => ['nullable','string','max:255']
        ];
    }

}
