<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ForgotPasswordRequest;
use App\Models\User;
use Spark\Facades\DB;
use Spark\Facades\Log;
use Spark\Facades\Mail;
use Spark\Http\Response;
use Spark\Support\Str;

class PasswordResetLinkController extends Controller
{
    /**
     * Display the forgot password view.
     */
    public function create(): Response
    {
        return view('auth.forgot-password');
    }

    /**
     * Handle an incoming password reset link request.
     */
    public function store(ForgotPasswordRequest $request): Response
    {
        $email = $request->validated()->string('email');
        $user = User::where('email', $email)->first();

        if ($user) {
            $token = Str::random(64);

            // Store in password_reset_tokens table
            DB::table('password_reset_tokens')->where('email', $email)->delete();
            DB::table('password_reset_tokens')->insert([
                'email' => $email,
                'token' => $token,
                'created_at' => now()->toDateTimeString(),
            ]);

            $resetUrl = route('password.reset', ['token' => $token, 'email' => $email]);

            try {
                Mail::to($user->email, $user->name)
                    ->subject('Reset Password Notification')
                    ->view('emails.password-reset', [
                        'user' => $user,
                        'resetUrl' => $resetUrl,
                    ])
                    ->send();
            } catch (\Throwable $e) {
                Log::error('Password reset email error: ' . $e->getMessage());
            }
        }

        return back()->with('status', 'If an account exists for that email, a password reset link has been sent.');
    }
}
