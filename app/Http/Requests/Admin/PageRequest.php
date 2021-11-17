<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use App\Model\Page;

class PageRequest extends FormRequest
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
        $model = request()->route('page');
        if ($model){
            // update
            if ($model->status == 'static'){
                $reqOrNull = 'nullable';
                $statusRule = 'in:static';
            } else {
                $reqOrNull = 'required';
                $statusRule = 'in:draft,published';
            }
            return [
                'title' => [$reqOrNull,'string','max:70'],
                'seo_title' => ['required','string','max:70'],
                'seo_description' => ['required','string','max:255'],
                'url' => [$reqOrNull,'string','max:255'],
                'status' => ['required',$statusRule],
                'content' => [$reqOrNull,'string','max:5000']
            ];
        }

        //create
        return [
            'title' => ['required','string','max:70'],
            'seo_title' => ['required','string','max:70'],
            'seo_description' => ['required','string','max:255'],
            'url' => ['required','string','max:255'],
            'status' => ['required','in:draft,published'],
            'content' => ['required','string','max:5000']
        ];
    }

}
