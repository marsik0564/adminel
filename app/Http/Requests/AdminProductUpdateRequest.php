<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminProductUpdateRequest extends FormRequest
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
            'title' => 'required|min:3|max:100|string',
            'category_id' => 'integer',
            'price' => 'required',
        ];
    }
    
    public function messages()
    {
        return [
            'price.required' => 'Цена обязательна для заполнения',
            'title.min' => 'Название должно быть длиной минимум 3 символа',
        ];
    }
}
