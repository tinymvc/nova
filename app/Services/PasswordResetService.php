<?php

namespace App\Services;

use App\Exceptions\PasswordResetDeliveryException;
use App\Models\User;
use RuntimeException;
use Spark\Facades\DB;
use Spark\Facades\Mail;
use Spark\Foundation\Exceptions\ValidationException;
use Spark\Http\Input;
use Spark\Support\Str;
use Throwable;

class PasswordResetService
{
    public function sendLink(string $email): void
    {
        $user = User::where('email', $email)->first();

        if (!$user) {
            return;
        }

        $token = Str::random(64);
        $digest = hash('sha256', $token);

        DB::transaction(function () use ($email, $digest): void {
            DB::table('password_reset_tokens')->where('email', $email)->delete();
            DB::table('password_reset_tokens')->insert([
                'email' => $email,
                'token' => $digest,
                'created_at' => now()->toDateTimeString(),
            ]);
        });

        try {
            $sent = Mail::to($user->email, $user->name)
                ->subject('Reset your Nova password')
                ->view('emails.password-reset', [
                    'user' => $user,
                    'resetUrl' => route('password.reset', ['token' => $token, 'email' => $email]),
                ])
                ->send();

            if (!$sent) {
                throw new RuntimeException('The mail transport did not accept the reset email.');
            }
        } catch (Throwable $exception) {
            DB::table('password_reset_tokens')
                ->where('email', $email)
                ->where('token', $digest)
                ->delete();

            throw new PasswordResetDeliveryException(
                'Unable to send the reset link. Please try again later.',
                previous: $exception,
            );
        }
    }

    public function reset(Input $data): void
    {
        DB::transaction(function () use ($data): void {
            $email = $data->string('email');
            $digest = hash('sha256', $data->string('token'));
            $record = DB::table('password_reset_tokens')->where('email', $email)->first();
            $user = User::where('email', $email)->first();

            if (
                !$record
                || !$user
                || !hash_equals($record->token, $digest)
                || carbon($record->created_at)->addMinutes(60)->isPast()
            ) {
                throw ValidationException::withMessages([
                    'email' => ['This reset link is invalid or has expired. Please request a new one.'],
                ]);
            }

            // Claim the single-use token before changing the password.
            $claimed = DB::table('password_reset_tokens')
                ->where('email', $email)
                ->where('token', $digest)
                ->delete();

            if ($claimed !== 1) {
                throw ValidationException::withMessages([
                    'email' => ['This reset link has already been used.'],
                ]);
            }

            $user->password = $data->string('password');
            $user->remember_token = Str::random(60);

            if (!$user->save()) {
                throw new RuntimeException('Unable to reset your password.');
            }
        });
    }
}
