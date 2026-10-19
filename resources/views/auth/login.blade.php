@extends('layouts.auth')
@section('title', 'Sign In')

@section('content')
    <div class="mb-6 text-center">
        <h2 class="text-xl font-bold text-base-content">Welcome back</h2>
        <p class="text-xs text-base-content/60 mt-1">Please enter your credentials to access your account</p>
    </div>

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf

        <x-input
            name="email"
            type="email"
            label="Email Address"
            placeholder="name@example.com"
            icon="mail"
            required
            autofocus
        />

        <x-input
            name="password"
            type="password"
            label="Password"
            placeholder="••••••••"
            icon="lock"
            required
        />

        <div class="flex items-center justify-between text-xs">
            <x-checkbox name="remember" label="Remember me" />

            <x-link href="{{ route('password.request') }}" variant="primary" class="text-xs" x-navigate>
                Forgot password?
            </x-link>
        </div>

        <div class="pt-2">
            <x-button type="submit" variant="primary" class="w-full shadow-md shadow-primary/20">
                Sign In
            </x-button>
        </div>
    </form>

    <x-divider label="OR" />

    <p class="text-center text-xs text-base-content/70">
        Don't have an account yet?
        <x-link href="{{ route('register') }}" variant="primary" x-navigate>
            Create an account
        </x-link>
    </p>
@endsection
