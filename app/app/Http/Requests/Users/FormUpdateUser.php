<?php

namespace App\Http\Requests\Users;

use Illuminate\Foundation\Http\FormRequest;

class FormUpdateUser extends FormRequest
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
            'name'                      => 'nullable|regex:/^[A-Za-z]+$/',
            'user_name'                 => 'nullable|string|unique:users,user_name',
            'email'                     => 'nullable|email|unique:users,email',
            'password'                  => 'nullable|regex:/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$/',
            'cpf_cnpj'                  => 'nullable|string|min:11|max:14|regex:/(\d+)/',
        ];
    }

    public function messages()
    {
        // ... (as mensagens continuam as mesmas)
        return [
            'unique'                    => 'The registered :attribute already exists.',
            'email'                     => 'The :attribute field must be a valid email address.',
            'user_name.string'          => 'The :attribute field must be a string.',
            'access_level.string'       => 'The :attribute field must be a string.',
            'password.regex'            => 'The :attribute must be at least 8 characters long, including an uppercase letter, a lowercase letter, a number, and a special character.',
            'name.regex'                => 'The :attribute field must contain only letters.',
            'cpf_cnpj.min'              => 'Must contain at least 11 digits.',
            'cpf_cnpj.max'              => 'Must contain a maximum of 14 digits.',
            'cpf_cnpj.regex'            => 'Must contain only numbers.',
        ];
    }
    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        $response = response()->json([
            'success' => false,
            'message' => $validator->errors(),
        ], 422);

        throw new \Illuminate\Validation\ValidationException($validator, $response);
    }
}
