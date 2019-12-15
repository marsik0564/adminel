<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminUserEditRequest extends FormRequest
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
        $id = $_POST['id'];
        return [
            'name' => 'required|min:3|max:20|string',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                'unique:users,email,' . $id,
            ],
            'password' => 'nullable|string|min:8|max:20|confirmed',
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
