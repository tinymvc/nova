@extends('layouts.auth')
@section('title', 'Create Account')

@section('content')
    <div class="mb-6 text-center">
        <h2 class="text-xl font-bold text-base-content">Create an account</h2>
        <p class="text-xs text-base-content/60 mt-1">Get started with your new Nova application</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-3">
        @csrf

        <x-input
            name="name"
            type="text"
            label="Full Name"
            placeholder="John Doe"
            icon="user"
            required
            autofocus
        />

        <x-input
            name="username"
            type="text"
            label="Username"
            placeholder="johndoe"
            icon="user"
            help="Alphanumeric, at least 3 characters"
            required
        />

        <x-input
            name="email"
            type="email"
            label="Email Address"
            placeholder="john@example.com"
            icon="mail"
            required
        />

        <x-input
            name="password"
            type="password"
            label="Password"
            placeholder="••••••••"
            icon="lock"
            help="Minimum 8 characters"
            required
        />

        <x-input
            name="password_confirmation"
            type="password"
            label="Confirm Password"
            placeholder="••••••••"
            icon="lock"
            required
        />

        <div class="pt-3">
            <x-button type="submit" variant="primary" class="w-full shadow-md shadow-primary/20">
                Create Account
            </x-button>
        </div>
    </form>

    <x-divider label="OR" />

    <p class="text-center text-xs text-base-content/70">
        Already have an account?
        <x-link href="{{ route('login') }}" variant="primary" x-navigate>
            Sign in
        </x-link>
    </p>
@endsection
