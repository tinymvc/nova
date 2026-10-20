@if (!is_fire_js())
    @extends('layouts.base')
@endif
@section('title')
    Forgot password? · {{ config('app.name', 'Nova') }}
@endsection

@section('content')
    <x-layouts.auth key="forgot-password">
        <span class="grid place-items-center w-11 h-11 rounded-xl bg-secondary text-primary mb-6"><x-icon
                name="key" /></span>
        <h1 data-page-heading tabindex="-1" class="text-3xl font-medium tracking-[-0.045em]">Forgot password?</h1>
        <p class="muted text-sm leading-6 mt-3 mb-8">It happens. Enter your email and we’ll send you a link to get back in.
        </p>
        <x-form :action="route('password.email')">
            <x-input name="email" type="email" label="Email address" placeholder="you@example.com" autocomplete="email"
                required />
            <x-submit label="Send reset link" processing="Sending link…" class="w-full" />
        </x-form>
        <a href="{{ route('login') }}" x-navigate
            class="text-xs muted hover:text-base-content flex items-center justify-center gap-2 mt-8"><x-icon
                name="arrow-left" size="xs" />Back to sign in</a>
    </x-layouts.auth>
@endsection

@if (is_fire_js())
    @yield('content')
@endif
