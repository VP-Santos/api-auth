<?php

namespace App\Http\Requests\Users;

use Illuminate\Foundation\Http\FormRequest;

class VerifyTwoFactorRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Allow all users to make this request
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
            'email' => 'required|email',
            'code'  => 'required|string|size:6',
        ];
    }

    /**
     * Custom error messages in English.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'email.required' => 'The email field is required.',
            'email.email'    => 'The email must be a valid email address.',
            
            'code.required'  => 'The verification code is required.',
            'code.string'    => 'The verification code must be a string.',
            'code.size'      => 'The verification code must be exactly 6 characters.',
        ];
    }
}
