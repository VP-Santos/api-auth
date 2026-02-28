<?php

namespace App\Http\Requests\Users;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class ResetPasswordRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'token' => 'required|string',
            'email' => 'required|email|exists:users,email',
            'password' => [
                'required',
                'confirmed',
                Password::min(8)
                    ->mixedCase()
                    ->numbers()
                    ->symbols(),
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'token.required'        => 'Reset token is required.',
            'email.required'        => 'The email field is required.',
            'email.email'           => 'The email must be a valid email address.',
            'email.exists'          => 'No account found with this email address.',
            'password.required'     => 'The password field is required.',
            'password.confirmed'    => 'Password confirmation does not match.',
        ];
    }
}