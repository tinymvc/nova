<?php

namespace App\Http\Controllers\Auth;

use App\Exceptions\PasswordResetDeliveryException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ForgotPasswordRequest;
use App\Services\PasswordResetService;
use Spark\Http\Response;

class PasswordResetLinkController extends Controller
{
    public function create(): Response
    {
        return fire('auth.forgot-password');
    }

    public function store(ForgotPasswordRequest $request, PasswordResetService $passwords): Response
    {
        try {
            $passwords->sendLink($request->validated()->string('email'));
        } catch (PasswordResetDeliveryException $exception) {
            return is_fire_js()
                ? fire()->error($exception->getMessage(), 503)
                : to_route('password.request')->with('error', $exception->getMessage());
        }

        $message = 'If an account exists for that email, a password reset link has been sent.';

        return is_fire_js()
            ? fire()->success($message)
            : to_route('password.request')->with('status', $message);
    }
}
