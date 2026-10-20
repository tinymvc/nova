@if (!is_fire_js())
    @extends('layouts.base')
@endif
@section('title')
    Create an account · {{ config('app.name', 'Nova') }}
@endsection

@section('content')
    <x-layouts.auth key="register">
        <p class="eyebrow mb-3">Something good starts here</p>
        <h1 data-page-heading tabindex="-1" class="text-3xl font-medium tracking-[-0.045em]">Make room for your ideas.</h1>
        <p class="muted text-sm mt-3 mb-8">Create your account. Make Nova your own.</p>
        <x-form :action="route('register')">
            <div class="grid sm:grid-cols-2 gap-4">
                <x-input name="name" label="Full name" placeholder="Alex Morgan" autocomplete="name" maxlength="255"
                    required />
                <x-input name="username" label="Username" placeholder="alexmorgan" autocomplete="username" minlength="3"
                    maxlength="50" required />
            </div>
            <x-input name="email" type="email" label="Email address" placeholder="you@example.com" autocomplete="email"
                maxlength="255" required />
            <x-input name="password" type="password" label="Password" placeholder="Create a password"
                help="Use at least 8 characters." autocomplete="new-password" minlength="8" required />
            <x-input name="password_confirmation" type="password" label="Confirm password" placeholder="One more time"
                autocomplete="new-password" minlength="8" required />
            <x-submit label="Create account" processing="Creating account…" class="w-full" />
        </x-form>
        <p class="text-xs muted text-center mt-7">Already have an account? <a href="{{ route('login') }}" x-navigate
                class="text-primary font-medium hover:underline">Sign in</a></p>
    </x-layouts.auth>
@endsection

@if (is_fire_js())
    @yield('content')
@endif
