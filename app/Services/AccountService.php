<?php

namespace App\Services;

use App\Models\User;
use Spark\Facades\{Auth, DB, Hash, Session};
use Spark\Foundation\Exceptions\ValidationException;
use Spark\Http\Input;
use RuntimeException;

class AccountService
{
    public function register(Input $data): User
    {
        $user = User::create($data->only('name', 'username', 'email', 'password'));

        Auth::login($user);
        Session::regenerate();

        return $user;
    }

    public function authenticate(Input $credentials, bool $remember): void
    {
        if (!Auth::attempt($credentials, remember: $remember)) {
            throw ValidationException::withMessages([
                'email' => ['These credentials do not match our records.'],
            ]);
        }

        Session::regenerate();
    }

    public function changePassword(User $user, Input $data): void
    {
        if (!Hash::verify($data->string('current_password'), $user->password)) {
            throw ValidationException::withMessages([
                'current_password' => ['Your current password is incorrect.'],
            ]);
        }

        DB::transaction(function () use ($user, $data): void {
            $saved = $user->update([
                'password' => $data->password(hash: true),
                'remember_token' => Hash::random(32),
            ]);

            if (!$saved) {
                throw new RuntimeException('Unable to update your password.');
            }

            DB::table('password_reset_tokens')
                ->where('email', $user->email)
                ->delete();
        });

        Session::regenerate();
    }

    public function logout(): void
    {
        Auth::check() && Auth::logout();

        Session::invalidate();
    }
}
