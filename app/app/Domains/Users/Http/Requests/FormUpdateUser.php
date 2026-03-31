<?php

namespace App\Domains\Users\Http\Requests;

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
            'name'                      => 'nullable|regex:/^[\pL]+(?:\s[\pL]+)*$/u',
            'user_name'                 => 'nullable|string|unique:users,user_name',
            'email'                     => 'nullable|email|unique:users,email',
        ];
    }

    public function messages()
    {
        return [
            'unique'                    => 'The registered :attribute already exists.',
            'email'                     => 'The :attribute field must be a valid email address.',
            'user_name.string'          => 'The :attribute field must be a string.',
            'name.regex'                => 'The name may only contain letters and spaces.',
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
