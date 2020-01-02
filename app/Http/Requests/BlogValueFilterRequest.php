<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BlogValueFilterRequest extends FormRequest
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
            'attr_group_id' => 'integer'
        ];
    }
    
    public function messages()
    {
        return [
            'title.min' => 'Минимальная длина названия 4 символа',
            'title.max' => 'Максимальная длина названия 25 символов',
            'attr_group_id' => 'Номер группы должен быть натуральным числом'
        ];
    }
}
