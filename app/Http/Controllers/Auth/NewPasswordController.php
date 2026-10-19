<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ResetPasswordRequest;
use App\Models\User;
use Spark\Facades\DB;
use Spark\Http\Request;
use Spark\Http\Response;

class NewPasswordController extends Controller
{
    /**
     * Display the password reset view.
     */
    public function create(string $token): Response
    {
        return view('auth.reset-password', [
            'token' => $token,
            'email' => request()->query('email', ''),
        ]);
    }

    /**
     * Handle an incoming new password request.
     */
    public function store(ResetPasswordRequest $request): Response
    {
        $email = $request->validated()->string('email');
        $token = $request->validated()->string('token');
        $newPassword = $request->validated()->string('password');

        $record = DB::table('password_reset_tokens')
            ->where('email', $email)
            ->where('token', $token)
            ->first();

        if (!$record) {
            return back()->withErrors(['email' => 'This password reset token is invalid or has expired.'])->withInput();
        }

        // Verify token expiry (60 minutes)
        if (carbon($record->created_at)->addMinutes(60)->isPast()) {
            DB::table('password_reset_tokens')->where('email', $email)->delete();

            return back()->withErrors(['email' => 'This password reset token has expired. Please request a new one.'])->withInput();
        }

        $user = User::where('email', $email)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'We could not find an account associated with this email address.'])->withInput();
        }

        $user->password = $newPassword;
        $user->save();

        // Remove the single-use token immediately
        DB::table('password_reset_tokens')->where('email', $email)->delete();

        return redirect(route('login'))->with('status', 'Your password has been successfully reset. Please sign in with your new password.');
    }
}
