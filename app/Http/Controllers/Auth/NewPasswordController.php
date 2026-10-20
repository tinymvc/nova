<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ResetPasswordRequest;
use App\Services\PasswordResetService;
use Spark\Http\Request;
use Spark\Http\Response;

class NewPasswordController extends Controller
{
    public function create(string $token, Request $request): Response
    {
        return fire('auth.reset-password', [
            'token' => $token,
            'email' => $request->query('email', ''),
        ]);
    }

    public function store(ResetPasswordRequest $request, PasswordResetService $passwords): Response
    {
        $passwords->reset($request->validated());

        return fire()->navigate((string) route('login'))
            ->with('status', 'Password reset. Sign in with your new password.');
    }
}
