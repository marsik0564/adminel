<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminCurrencyRequest extends FormRequest
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
        $id = $_POST['id'] ?? '';
        return [
            'code' => 'min:3|max:3|string|unique:currencies,code,' . $id,
            'title' => 'min:3|max:25|unique:currencies,title,' . $id,
        ];
    }
    
    public function messages()
    {
        return [
            'code.min' => 'Длина кода должна составлять 3 символа',
            'code.max' => 'Длина кода должна составлять 3 символа',
            'title.max' => 'Максимальная длина названия 25 сивмолов',
            'code.unique' => 'Валюта с таким кодом уже добавлена',
            'title.unique' => 'Валюта с таким названием уже добавлена',
        ];
    }
}
