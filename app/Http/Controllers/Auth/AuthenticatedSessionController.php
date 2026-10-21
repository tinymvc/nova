<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Services\AccountService;
use Spark\Fire\Fire;
use Spark\Http\Response;

class AuthenticatedSessionController extends Controller
{
    public function store(LoginRequest $request, AccountService $accounts): Response
    {
        $accounts->authenticate(
            $request->validated()->only('email', 'password'),
            $request->boolean('remember'),
        );

        return Fire::navigate(route('dashboard'))
            ->with('status', 'Welcome back.');
    }

    public function destroy(AccountService $accounts): Response
    {
        $accounts->logout();

        return Fire::navigate(route('home'));
    }
}
