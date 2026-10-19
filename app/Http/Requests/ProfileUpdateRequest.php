<?php

namespace App\Http\Requests;

use Spark\Facades\Auth;
use Spark\Foundation\Http\FormRequest;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        $userId = Auth::id();

        return [
            'name' => 'required|string|max:255',
            'username' => ['required', 'string', 'alpha_dash', 'min:3', 'max:50', ['unique' => ['users', 'username', $userId]]],
            'email' => ['required', 'string', 'email', 'max:255', ['unique' => ['users', 'email', $userId]]],
            'current_password' => 'nullable|string',
            'password' => 'nullable|string|min:8|confirmed',
        ];
    }

    /**
     * Custom messages.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Please provide your full name.',
            'username.required' => 'Username cannot be blank.',
            'username.unique' => 'This username is already taken by another account.',
            'email.required' => 'Email address cannot be blank.',
            'email.unique' => 'This email address is already in use by another account.',
            'password.min' => 'New password must be at least 8 characters long.',
            'password.confirmed' => 'New password confirmation does not match.',
        ];
    }
}
