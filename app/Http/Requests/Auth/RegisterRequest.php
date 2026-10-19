<?php

namespace App\Http\Requests\Auth;

use Spark\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'username' => ['required', 'string', 'alpha_dash', 'min:3', 'max:50', ['unique' => ['users', 'username']]],
            'email' => ['required', 'string', 'email', 'max:255', ['unique' => ['users', 'email']]],
            'password' => 'required|string|min:8|confirmed',
        ];
    }

    /**
     * Custom error messages.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Please provide your full name.',
            'username.required' => 'Please choose a username.',
            'username.unique' => 'This username is already taken.',
            'email.required' => 'Please enter your email address.',
            'email.unique' => 'An account with this email address already exists.',
            'password.required' => 'Please provide a password.',
            'password.min' => 'Password must be at least 8 characters long.',
            'password.confirmed' => 'Password confirmation does not match.',
        ];
    }
}
