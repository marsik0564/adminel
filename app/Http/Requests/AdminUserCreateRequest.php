<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminUserCreateRequest extends FormRequest
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
            'name' => 'required|min:3|max:20|string',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                \Illuminate\Validation\Rule::unique('users'),
            ],
            'password' => 'string|min:8|max:20|confirmed',
        ];
    }
    
    public function messages()
    {
        return [
            'name.min' => 'Минимальная длина имени 3 символа',
            'email.unique' => 'Такой email уже занят',
            'password.confirmed' => 'Пароли не совпадают',
        ];
    }
}
