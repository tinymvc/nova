<?php

namespace App\Services;

use App\Exceptions\PasswordResetDeliveryException;
use App\Jobs\SendResetPasswordJob;
use App\Models\User;
use RuntimeException;
use Spark\Carbon;
use Spark\Facades\{DB, Mail, Hash};
use Spark\Foundation\Exceptions\ValidationException;
use Spark\Http\Input;
use Throwable;

class PasswordResetService
{
    public function sendLink(string $email): void
    {
        $user = User::where('email', $email)
            ->first();

        if (!$user) {
            return;
        }

        $digest = hash('sha256', $token = Hash::random(32));

        DB::transaction(function () use ($email, $digest): void {
            DB::table('password_reset_tokens')
                ->where('email', $email)
                ->delete();

            DB::table('password_reset_tokens')->insert([
                'email' => $email,
                'token' => $digest,
                'created_at' => now(),
            ]);
        });

        SendResetPasswordJob::dispatch($user->id, $token, $digest);
    }

    public function sendResetEmail(User $user, string $token): void
    {
        try {
            $sent = Mail::to($user->email, $user->name)
                ->subject('Reset your Nova password')
                ->view('emails.password-reset', [
                    'user' => $user,
                    'resetUrl' => route('password.reset', ['token' => $token]),
                ])
                ->send();

            if (!$sent) {
                throw new RuntimeException('The mail transport did not accept the reset email.');
            }
        } catch (Throwable $exception) {
            throw new PasswordResetDeliveryException(
                'Unable to send the reset link. Please try again later.',
                previous: $exception,
            );
        }
    }

    public function reset(Input $data): void
    {
        DB::transaction(function () use ($data): void {
            $digest = hash('sha256', $data->string('token'));
            $record = DB::table('password_reset_tokens')
                ->where('token', $digest)
                ->first();

            if (
                !$record
                || Carbon::parse($record->created_at)->addMinutes(60)->isPast()
            ) {
                throw ValidationException::withMessages([
                    'token' => ['This reset link is invalid or has expired. Please request a new one.'],
                ]);
            }

            $user = User::where('email', $record->email)
                ->first();

            if (!$user) {
                throw ValidationException::withMessages([
                    'token' => ['This reset link is invalid or has expired. Please request a new one.'],
                ]);
            }

            // Claim the single-use token before changing the password.
            $claimed = DB::table('password_reset_tokens')
                ->where('email', $record->email)
                ->where('token', $digest)
                ->delete();

            if ($claimed !== 1) {
                throw ValidationException::withMessages([
                    'token' => ['This reset link has already been used.'],
                ]);
            }

            $saved = $user->update([
                'password' => $data->password(hash: true),
                'remember_token' => Hash::random(32),
            ]);

            if (!$saved) {
                throw new RuntimeException('Unable to reset your password.');
            }
        });
    }
}
