<?php

namespace App\Domains\Admin\Http\Requests;

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
            'name'                      => 'nullable|regex:/^[\pL]+(?:\s[\pL]+)*$/u',
            'user_name'                 => 'nullable|string|unique:users,user_name',
            'email'                     => 'nullable|email|unique:users,email',
            'password'                  => 'nullable|regex:/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$/',
        ];
    }

    public function messages()
    {
        return [
            'unique'                    => 'The :attribute has already been taken.',
            'email'                     => 'The :attribute must be a valid email address.',
            'user_name.string'          => 'The :attribute must be a string.',
            'access_level.string'       => 'The :attribute must be a string.',
            'password.regex'            => 'The :attribute must be at least 8 characters long and include uppercase letters, lowercase letters, numbers, and special characters.',
            'name.regex'                => 'The name may only contain letters and spaces.',
        ];
    }
}
