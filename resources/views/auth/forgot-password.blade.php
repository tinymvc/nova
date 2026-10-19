@extends('layouts.auth')
@section('title', 'Forgot Password')

@section('content')
    <div class="mb-6 text-center">
        <h2 class="text-xl font-bold text-base-content">Forgot password?</h2>
        <p class="text-xs text-base-content/60 mt-1">
            No worries! Enter your registered email address and we'll send you a secure password reset link.
        </p>
    </div>

    <form method="POST" action="{{ route('password.email') }}" class="space-y-4">
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

        <div class="pt-2">
            <x-button type="submit" variant="primary" class="w-full shadow-md shadow-primary/20">
                Email Password Reset Link
            </x-button>
        </div>
    </form>

    <div class="text-center mt-6">
        <x-link href="{{ route('login') }}" variant="hover" class="text-xs inline-flex items-center gap-1" x-navigate>
            <x-icon name="arrow-left" size="xs" />
            <span>Back to sign in</span>
        </x-link>
    </div>
@endsection
