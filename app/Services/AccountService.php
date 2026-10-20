<?php

namespace App\Services;

use App\Models\User;
use RuntimeException;
use Spark\Facades\Auth;
use Spark\Facades\DB;
use Spark\Facades\Hash;
use Spark\Facades\Session;
use Spark\Foundation\Exceptions\ValidationException;
use Spark\Http\Input;
use Spark\Support\Str;

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
            $user->password = $data->string('password');
            $user->remember_token = Str::random(60);

            if (!$user->save()) {
                throw new RuntimeException('Unable to update your password.');
            }

            DB::table('password_reset_tokens')->where('email', $user->email)->delete();
        });

        Session::regenerate();
    }

    public function logout(): void
    {
        Auth::logout();
        Session::invalidate();
    }
}
