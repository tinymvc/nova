<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Services\AccountService;
use Spark\Http\Response;

class AuthenticatedSessionController extends Controller
{
    public function create(): Response
    {
        return fire('auth.login');
    }

    public function store(LoginRequest $request, AccountService $accounts): Response
    {
        $accounts->authenticate(
            $request->validated()->only('email', 'password'),
            $request->boolean('remember'),
        );

        return fire()->navigate((string) route('dashboard'))->with('status', 'Welcome back.');
    }

    public function destroy(AccountService $accounts): Response
    {
        $accounts->logout();

        return fire()->navigate((string) route('home'));
    }
}
