<x-layouts.auth title="Reset Password · {{ config('app.name', 'Spark') }}" key="reset-password">
    <h1 data-page-heading tabindex="-1" class="text-2xl font-semibold tracking-tight text-center">Reset your password
    </h1>
    <p class="muted text-sm leading-6 mt-2 mb-7 text-center">Choose a new password to secure your account.</p>
    <x-form :action="route('password.update')">
        <input type="hidden" name="token" value="{{ $token }}">
        <x-input name="password" type="password" label="New password" help="Use at least 8 characters."
            autocomplete="new-password" minlength="8" required />
        <x-input name="password_confirmation" type="password" label="Confirm new password" autocomplete="new-password"
            minlength="8" required />
        <div class="space-y-4 -mt-2">
            <x-error field="token" />
            <x-submit label="Reset password" processing="Resetting password…" class="w-full" />
        </div>
    </x-form>
    <a href="{{ route('password.request') }}" x-navigate
        class="block text-[13px] text-primary hover:underline text-center mt-7">Need a new reset link?</a>
</x-layouts.auth>
