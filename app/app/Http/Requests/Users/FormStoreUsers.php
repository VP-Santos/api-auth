<?php

namespace App\Http\Requests\Users;

use Illuminate\Foundation\Http\FormRequest;

class FormStoreUsers extends FormRequest
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
            'name'                      => 'required|regex:/^[A-Za-z]+$/',
            'user_name'                 => 'required|string|unique:users,user_name',
            'email'                     => 'required|email|unique:users,email',
            'password'                  => 'required|regex:/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$/',
            'cpf_cnpj'                  => 'required|string|min:11|max:14|regex:/(\d+)/',
            'access_level'              => 'required|string',
        ];
    }

    public function messages()
    {
        // ... (as mensagens continuam as mesmas)
        return [
            'required'                  => 'O campo :attribute deve ser obrigatório.',
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
