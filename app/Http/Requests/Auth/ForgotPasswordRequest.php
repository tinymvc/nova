<?php

namespace App\Http\Requests\Auth;

use Spark\Foundation\Http\FormRequest;

class ForgotPasswordRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'email' => 'required|string|email',
        ];
    }

    public function messages(): array
    {
        return [
            'email.required' => 'Please provide your account email address.',
            'email.email' => 'Please provide a valid email address.',
        ];
    }
}
