<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BlogGroupFilterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'min:4|max:25',
        ];
    }
    
    public function messages()
    {
        return [
            'title.min' => 'Минимальная длина названия 4 символа',
            'title.max' => 'Максимальная длина названия 25 символов',
        ];
    }
}
