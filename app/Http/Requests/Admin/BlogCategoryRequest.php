<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class BlogCategoryRequest extends FormRequest
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
        $model = request()->route('blog_category');
        $slugRule = 'unique:blog_categories,slug';
        $slugRule = $model ? $slugRule . (','.$model->id) : $slugRule;

        return [
            'name' => ['required','string','max:70'],
            'slug' => ['required', 'string', 'max:70', 'alpha_dash', $slugRule],
        ];
    }

}
