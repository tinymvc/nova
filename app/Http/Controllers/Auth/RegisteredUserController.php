<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Spark\Facades\Auth;
use Spark\Facades\Session;
use Spark\Http\Response;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): Response
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     */
    public function store(RegisterRequest $request): Response
    {
        $user = User::create([
            'name' => $request->validated()->string('name'),
            'username' => $request->validated()->string('username'),
            'email' => $request->validated()->string('email'),
            'password' => $request->validated()->string('password'),
        ]);

        Auth::login($user);
        Session::regenerate();

        return redirect(route('dashboard'))->with('status', 'Welcome to Nova! Your account has been created.');
    }
}
