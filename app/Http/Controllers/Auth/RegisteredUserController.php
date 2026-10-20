<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Services\AccountService;
use Spark\Http\Response;

class RegisteredUserController extends Controller
{
    public function create(): Response
    {
        return fire('auth.register');
    }

    public function store(RegisterRequest $request, AccountService $accounts): Response
    {
        $accounts->register($request->validated());

        return fire()->navigate((string) route('dashboard'))
            ->with('status', 'Welcome to Nova. Your account is ready.');
    }
}
