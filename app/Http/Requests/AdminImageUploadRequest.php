<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminImageUploadRequest extends FormRequest
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
            'file' => 'image|max:5000',
        ];
    }
    
    public function messages()
    {
        return [
            'file.image' => 'Ошибка! Файл должен быть картинкой',
            'file.max' => 'Ошибка! Максимальный размер файла - 5Мб',
        ];
    }
}
