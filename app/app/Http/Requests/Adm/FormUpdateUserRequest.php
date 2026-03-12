<?php

namespace App\Http\Requests\Adm;

use Illuminate\Foundation\Http\FormRequest;

class FormUpdateUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'                      => 'nullable|regex:/^[A-Za-z]+$/',
            'user_name'                 => 'nullable|string|unique:users,user_name',
            'email'                     => 'nullable|email|unique:users,email',
            'password'                  => 'nullable|regex:/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$/',
            'cpf_cnpj'                  => 'nullable|string|min:11|max:14|regex:/(\d+)/',
        ];
    }

    public function messages()
    {
        return [
            'unique'                    => 'O :attribute cadastrado já existe.',
            'email'                     => 'O campo :attribute deve ser um endereço de e-mail válido.',
            'user_name.string'          => 'O campo :attribute deve ser um texto.',
            'access_level.string'       => 'O campo :attribute deve ser um texto.',
            'password.regex'            => 'A :attribute deve ter no mínimo 8 caracteres, incluindo letra maiúscula, letra minúscula, número e caracter especial.',
            'name.regex'                => 'O campo :attribute deve conter apenas letras.',
            'cpf_cnpj.min'              => 'deve conter no minimo 11 digitos',
            'cpf_cnpj.max'              => 'deve conter no maximo 14 digitos',
            'cpf_cnpj.regex'            => 'deve conter apenas numeros',
        ];
    }
}
