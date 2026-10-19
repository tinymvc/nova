<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Spark\Facades\Auth;
use Spark\Facades\Session;
use Spark\Http\Request;
use Spark\Http\Response;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): Response
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): Response
    {
        $credentials = $request->validated()->only('email', 'password');
        $remember = $request->boolean('remember');

        if (Auth::attempt($credentials, remember: $remember)) {
            Session::regenerate();

            return redirect(route('dashboard'))->with('status', 'Welcome back!');
        }

        return back()
            ->withErrors(['email' => 'These credentials do not match our records.'])
            ->withInput();
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): Response
    {
        Auth::logout();
        Session::invalidate();

        return redirect('/')->with('status', 'You have been logged out.');
    }
}
