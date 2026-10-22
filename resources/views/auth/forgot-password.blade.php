<x-layouts.auth title="Forgot password? · {{ config('app.name', 'Spark') }}" key="forgot-password">
    <h1 data-page-heading tabindex="-1" class="text-2xl font-semibold tracking-tight text-center">Forgot your
        password?</h1>
    <p class="muted text-sm leading-6 mt-2 mb-7 text-center">Enter your email address and we’ll send you a password
        reset link.
    </p>
    <x-form :action="route('password.email')">
        <x-input name="email" type="email" label="Email address" placeholder="you@example.com" autocomplete="email"
            required />
        <x-submit label="Send reset link" processing="Sending link…" class="w-full" />
    </x-form>
    <a href="{{ route('login') }}" x-navigate
        class="text-[13px] muted hover:text-base-content flex items-center justify-center gap-2 mt-8"><x-icon
            name="arrow-left" size="xs" />Back to sign in</a>
</x-layouts.auth>
