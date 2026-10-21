<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Services\AccountService;
use Spark\Fire\Fire;
use Spark\Http\Response;

class RegisteredUserController extends Controller
{
    public function store(RegisterRequest $request, AccountService $accounts): Response
    {
        $accounts->register($request->validated());

        return Fire::navigate(route('dashboard'))
            ->with('status', 'Welcome to Nova. Your account is ready.');
    }
}
