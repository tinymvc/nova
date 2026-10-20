@if (!is_fire_js())
    @extends('layouts.base')
@endif
@section('title')
    Reset Password · {{ config('app.name', 'Nova') }}
@endsection

@section('content')
    <x-layouts.auth key="reset-password">
        <span class="grid place-items-center w-11 h-11 rounded-xl bg-secondary text-primary mb-6"><x-icon
                name="lock" /></span>
        <h1 data-page-heading tabindex="-1" class="text-3xl font-medium tracking-[-0.045em]">A fresh start.</h1>
        <p class="muted text-sm leading-6 mt-3 mb-8">Choose a new password for your account.</p>
        <x-form :action="route('password.update')">
            <input type="hidden" name="token" value="{{ $token }}">
            <x-input name="email" type="email" label="Email address" :value="$email" autocomplete="email" required />
            <x-input name="password" type="password" label="New password" help="Use at least 8 characters."
                autocomplete="new-password" minlength="8" required />
            <x-input name="password_confirmation" type="password" label="Confirm new password" autocomplete="new-password"
                minlength="8" required />
            <x-submit label="Reset password" processing="Resetting password…" class="w-full" />
        </x-form>
        <a href="{{ route('password.request') }}" x-navigate
            class="text-xs text-primary hover:underline text-center mt-7">Need a new reset link?</a>
    </x-layouts.auth>
@endsection

@if (is_fire_js())
    @yield('content')
@endif
