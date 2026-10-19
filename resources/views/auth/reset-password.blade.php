@extends('layouts.auth')
@section('title', 'Reset Password')

@section('content')
    <div class="mb-6 text-center">
        <h2 class="text-xl font-bold text-base-content">Reset your password</h2>
        <p class="text-xs text-base-content/60 mt-1">Please enter your new password below</p>
    </div>

    <form method="POST" action="{{ route('password.update') }}" class="space-y-4">
        @csrf

        <input type="hidden" name="token" value="{{ $token }}" />

        <x-input
            name="email"
            type="email"
            label="Email Address"
            :value="$email"
            icon="mail"
            required
            readonly
        />

        <x-input
            name="password"
            type="password"
            label="New Password"
            placeholder="••••••••"
            icon="lock"
            help="Minimum 8 characters"
            required
            autofocus
        />

        <x-input
            name="password_confirmation"
            type="password"
            label="Confirm New Password"
            placeholder="••••••••"
            icon="lock"
            required
        />

        <div class="pt-2">
            <x-button type="submit" variant="primary" class="w-full shadow-md shadow-primary/20">
                Reset Password
            </x-button>
        </div>
    </form>
@endsection
