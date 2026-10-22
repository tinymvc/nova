<x-layouts.auth title="Create an account · {{ config('app.name', 'Spark') }}" key="register">
    <h1 data-page-heading tabindex="-1" class="text-2xl font-semibold tracking-tight text-center">Create an account</h1>
    <p class="muted text-sm mt-2 mb-7 text-center">Enter your details to create your account.</p>
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
        <x-input name="password_confirmation" type="password" label="Confirm password"
            placeholder="Repeat your password" autocomplete="new-password" minlength="8" required />
        <x-submit label="Create account" processing="Creating account…" class="w-full" />
    </x-form>
    <p class="text-[13px] muted text-center mt-7">Already have an account? <a href="{{ route('login') }}" x-navigate
            class="text-primary font-medium hover:underline">Sign in</a></p>
</x-layouts.auth>
