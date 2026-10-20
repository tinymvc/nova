@if (!is_fire_js())
    @extends('layouts.base')
@endif
@section('title')
    Sign in · {{ config('app.name', 'Nova') }}
@endsection

@section('content')
    <x-layouts.auth key="login">
        <p class="eyebrow mb-3">Your workspace awaits</p>
        <h1 data-page-heading tabindex="-1" class="text-3xl font-medium tracking-[-0.045em]">Welcome back.</h1>
        <p class="muted text-sm mt-3 mb-8">Sign in to pick up where you left off.</p>
        <x-form :action="route('login')">
            <x-input name="email" type="email" label="Email address" placeholder="you@example.com" autocomplete="email"
                required />
            <x-input name="password" type="password" label="Password" placeholder="Enter your password"
                autocomplete="current-password" required />
            <div class="flex items-center justify-between gap-3 text-xs">
                <label class="inline-flex items-center gap-2 cursor-pointer muted"><input
                        class="checkbox checkbox-primary checkbox-xs" type="checkbox" name="remember" value="1"
                        @checked(old('remember'))>Remember me</label>
                <a href="{{ route('password.request') }}" class="text-primary hover:underline" x-navigate>Forgot
                    password?</a>
            </div>
            <x-submit label="Sign in" processing="Signing in…" class="w-full mt-2" />
        </x-form>
        <p class="text-xs muted text-center mt-8">New around here? <a href="{{ route('register') }}" x-navigate
                class="text-primary font-medium hover:underline">Create an account</a></p>
    </x-layouts.auth>
@endsection

@if (is_fire_js())
    @yield('content')
@endif
