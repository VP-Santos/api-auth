<?php

namespace App\Http\Requests\Users;

use Illuminate\Foundation\Http\FormRequest;

class FormUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|regex:/^[A-Za-z]+$/',
            'user_name' => 'required|string|unique:users,user_name',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|regex:/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$/',
            'adm' => 'required|integer|in:0,1',
        ];
    }

    public function messages()
    {
        return [
            'required' => 'o :attribute deve ser obrigatorio',
            'string' => 'o :attribute deve conter apenas letras',
            'unique' => 'O :attribute cadastrado já existe',
            'email' => 'o :attribute deve ser um endereço de email válido',
            'regex' => ':attribute deve ter 8 digitos sendo letra maiuscula, letra minuscula e caracter especial',
            'name.regex' => ':attribute deve apenas conter letras',
            'integer' => 'o :attribute deve ser numérico',
            'in' => 'só é permitido 0 e 1',
        ];
    }
}
