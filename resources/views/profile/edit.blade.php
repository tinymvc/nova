@if (!is_fire_js())
    @extends('layouts.base')
@endif
@section('title')
    Profile Settings · {{ config('app.name', 'Nova') }}
@endsection

@section('content')
    <x-layouts.app title="Account settings" active="profile" key="profile-{{ $user->updated_at }}">
        <p class="eyebrow mb-3">A little more you</p>
        <h1 data-page-heading tabindex="-1" class="text-3xl font-medium tracking-[-0.045em]">Account settings</h1>
        <p class="text-sm muted mt-3 mb-9">Your details, your preferences. Keep everything up to date.</p>
        <div class="space-y-6 max-w-4xl">
            <section class="panel grid md:grid-cols-[0.8fr_1.2fr] gap-7 p-6 sm:p-8" aria-labelledby="profile-heading">
                <div>
                    <h2 id="profile-heading" class="text-sm font-medium">Profile information</h2>
                    <p class="text-xs muted leading-6 mt-2 max-w-52">The basics. How we know you and where we can reach you.
                    </p><x-avatar :name="$user->name" size="lg" class="mt-6" />
                </div>
                <x-form :action="route('profile.update')" method="PATCH">
                    <x-input name="name" label="Full name" :value="$user->name" autocomplete="name" required />
                    <x-input name="username" label="Username" :value="$user->username" autocomplete="username" minlength="3"
                        maxlength="50" required />
                    <x-input name="email" type="email" label="Email address" :value="$user->email" autocomplete="email"
                        required />
                    <div class="pt-1"><x-submit label="Save changes" /></div>
                </x-form>
            </section>
            <section class="panel grid md:grid-cols-[0.8fr_1.2fr] gap-7 p-6 sm:p-8" aria-labelledby="password-heading">
                <div>
                    <h2 id="password-heading" class="text-sm font-medium">Password & security</h2>
                    <p class="text-xs muted leading-6 mt-2 max-w-52">A strong password keeps your workspace yours.</p><span
                        class="mt-5 inline-flex text-primary"><x-icon name="shield-check" size="lg" /></span>
                </div>
                <x-form :action="route('profile.password')" method="PUT">
                    <x-input name="current_password" type="password" label="Current password"
                        autocomplete="current-password" required />
                    <x-input name="password" type="password" label="New password" help="Use at least 8 characters."
                        autocomplete="new-password" minlength="8" required />
                    <x-input name="password_confirmation" type="password" label="Confirm new password"
                        autocomplete="new-password" minlength="8" required />
                    <div class="pt-1"><x-submit label="Update password" processing="Updating…" /></div>
                </x-form>
            </section>
        </div>
    </x-layouts.app>
@endsection

@if (is_fire_js())
    @yield('content')
@endif
