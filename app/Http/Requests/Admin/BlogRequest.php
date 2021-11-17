<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\NotEmptySummernote;

class BlogRequest extends FormRequest
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
        $model = request()->route('blog');
        $slugRule = 'unique:blogs,slug';
        $slugRule = $model ? $slugRule . (','.$model->id) : $slugRule;

        return [
            'title' => ['required','string','max:70'],
            'slug' => ['required', 'string', 'max:70', 'alpha_dash', $slugRule],
            'seo_title' => ['nullable', 'string', 'max:70'],
            'seo_description' => ['nullable', 'string', 'max:255'],
            'categories' => ['required'],
            'categories.*' => ['required', 'exists:blog_categories,id'],
            'content' => ['required','string','max:10000', new NotEmptySummernote],
            'image' => $model ? 'nullable' : 'required'
        ];
    }

}
