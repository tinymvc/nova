<?php

namespace App\Http\Requests\Auth;

use Spark\Foundation\Http\FormRequest;

class ResetPasswordRequest extends FormRequest
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
     */
    public function rules(): array
    {
        return [
            'token' => 'required|string',
            'email' => 'required|string|email',
            'password' => 'required|string|min:8|confirmed',
        ];
    }

    /**
     * Custom messages.
     */
    public function messages(): array
    {
        return [
            'token.required' => 'Password reset token is missing or invalid.',
            'email.required' => 'Email address is required.',
            'password.required' => 'A new password is required.',
            'password.min' => 'Password must be at least 8 characters long.',
            'password.confirmed' => 'Password confirmation does not match.',
        ];
    }
}
