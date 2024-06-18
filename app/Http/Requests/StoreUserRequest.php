<?php

namespace App\Http\Requests;

use App\Models\User;
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
            'name' => ['min:3', 'max:25'],
            'email' => 'required|string|lowercase|email|max:255|unique:' . User::class,
            'password' => ['required','confirmed']
        ];
    }

    public function messages()
    {
        return [
            'name.min' => 'O nome do usuário deve conter no minimo 3 caracteres!',
            'name.max' => 'O nome do usuário deve conter no maximo 25 caracteres!',
            'email.required' => 'O email é obrigatório',
            'email.lowercase' => 'O email deve conter apenas letras minusculas!',
            'email.email' => 'Email invalido',
            'email.max' => 'O email deve conter menos de 255 caracteres',
            'email.unique' => 'Este email já esta em uso!',
            'password.required' => 'A senha é obrigatória',
            'password.confirmed' => 'Os campos de senha são divergentes'
        ];
    }
}
