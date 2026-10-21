<?php

namespace App\Services;

use App\Models\User;
use App\Http\Controllers\Auth\{
    AuthenticatedSessionController,
    NewPasswordController,
    RegisteredUserController
};
use Spark\Facades\{Auth, DB, Hash, Route, Session};
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

            DB::table('password_reset_tokens')->where('email', $user->email)->delete();
        });

        Session::regenerate();
    }

    public function logout(): void
    {
        Auth::check() && Auth::logout();

        Session::invalidate();
    }

    public static function routes(): void
    {
        Route::group(['middleware' => 'guest'], function () {
            Route::fire('/login', 'auth.login')
                ->name('login');

            Route::post('/login', [AuthenticatedSessionController::class, 'store'])
                ->middleware('throttle:10,1');

            Route::fire('/register', 'auth.register')
                ->name('register');

            Route::post('/register', [RegisteredUserController::class, 'store'])
                ->middleware('throttle:10,1');

            Route::fire('/forgot-password', 'auth.forgot-password')
                ->name('password.request');

            Route::post('/forgot-password', [NewPasswordController::class, 'link'])
                ->name('password.email')
                ->middleware('throttle:5,1');

            Route::get('/reset-password/{token}', [NewPasswordController::class, 'request'])
                ->name('password.reset');

            Route::post('/reset-password', [NewPasswordController::class, 'reset'])
                ->name('password.update')
                ->middleware('throttle:10,1');
        });

        Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
            ->name('logout');
    }
}
