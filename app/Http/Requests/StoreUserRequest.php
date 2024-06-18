<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['min:3','max:25']
        ];
    }

    public function messages()
    {
       return [
            'name.min' => 'O nome do usuário deve conter no minimo 3 caracteres!',
            'name.max' => 'O nome do usuário deve conter no maximo 25 caracteres!'
        ];
    }
}
