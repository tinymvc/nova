<?php

namespace App\Http\Controllers\Auth;

use App\Exceptions\PasswordResetDeliveryException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ForgotPasswordRequest;
use App\Http\Requests\Auth\ResetPasswordRequest;
use App\Services\PasswordResetService;
use Spark\Fire\Fire;
use Spark\Http\Request;
use Spark\Http\Response;

class NewPasswordController extends Controller
{
    public function link(ForgotPasswordRequest $request, PasswordResetService $passwords): Response
    {
        try {
            $passwords->sendLink($request->validated()->string('email'));
        } catch (PasswordResetDeliveryException $exception) {
            return Fire::error($exception->getMessage(), 503);
        }

        return Fire::success('If an account exists for that email, a password reset link has been sent.');
    }

    public function request(string $token, Request $request): Response
    {
        return Fire::render('auth.reset-password', [
            'token' => $token,
            'email' => $request->query('email', ''),
        ]);
    }

    public function reset(ResetPasswordRequest $request, PasswordResetService $passwords): Response
    {
        $passwords->reset($request->validated());

        return Fire::navigate(route('login'))
            ->with('status', 'Password reset. Sign in with your new password.');
    }
}
