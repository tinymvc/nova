<x-layouts.app title="Account settings" active="profile" key="profile-{{ $user->updated_at }}">
    <x-breadcrumb :items="[['label' => 'Overview', 'url' => route('dashboard')], ['label' => 'Account settings']]" class="mb-3 py-0" />
    <x-page-header title="Account settings"
        description="Manage your personal information and keep your account secure." />
    <div class="max-w-5xl">
        <section class="grid md:grid-cols-[0.65fr_1.35fr] gap-6 lg:gap-10 pb-8" aria-labelledby="profile-heading">
            <div>
                <span class="icon-tile mb-4"><x-icon name="user" /></span>
                <h2 id="profile-heading" class="text-sm font-semibold">Profile information</h2>
                <p class="text-[13px] muted leading-6 mt-2 max-w-64">Your name and email are used to identify your
                    account.</p>
            </div>
            <div class="panel overflow-hidden">
                <div class="flex items-center gap-3 p-6 border-b border-base-300 bg-base-200/50">
                    <x-avatar :name="$user->name" size="lg" shape="rounded" />
                    <div class="min-w-0">
                        <p class="text-sm font-semibold truncate">{{ $user->name }}</p>
                        <p class="text-xs muted truncate mt-0.5">{{ $user->email }}</p>
                    </div>
                </div>
                <x-form :action="route('profile.update')" method="PATCH" class="p-6">
                    <div class="grid sm:grid-cols-2 gap-5">
                        <x-input name="name" label="Full name" :value="$user->name" autocomplete="name" maxlength="255"
                            required />
                        <x-input name="username" label="Username" :value="$user->username" autocomplete="username"
                            minlength="3" maxlength="50" required />
                    </div>
                    <x-input name="email" type="email" label="Email address" :value="$user->email"
                        help="Used to sign in and recover your account." autocomplete="email" maxlength="255"
                        required />
                    <div class="flex justify-end border-t border-base-300 pt-5"><x-submit label="Save changes" /></div>
                </x-form>
            </div>
        </section>
        <section class="grid md:grid-cols-[0.65fr_1.35fr] gap-6 lg:gap-10 pt-8 border-t border-base-300"
            aria-labelledby="password-heading">
            <div>
                <span class="icon-tile mb-4"><x-icon name="shield-check" /></span>
                <h2 id="password-heading" class="text-sm font-semibold">Password & security</h2>
                <p class="text-[13px] muted leading-6 mt-2 max-w-64">Choose a strong password that you don’t use for
                    other accounts.</p>
            </div>
            <div class="panel overflow-hidden">
                <div class="flex items-center gap-3 px-6 py-5 border-b border-base-300 bg-base-200/50">
                    <x-icon name="lock" class="muted" />
                    <div>
                        <h3 class="text-[13px] font-medium">Change password</h3>
                        <p class="text-xs muted mt-0.5">Confirm your current password to set a new one.</p>
                    </div>
                </div>
                <x-form :action="route('profile.password')" method="PUT" class="p-6">
                    <x-input name="current_password" type="password" label="Current password"
                        autocomplete="current-password" required />
                    <div class="grid sm:grid-cols-2 gap-5">
                        <x-input name="password" type="password" label="New password" help="Use at least 8 characters."
                            autocomplete="new-password" minlength="8" required />
                        <x-input name="password_confirmation" type="password" label="Confirm new password"
                            autocomplete="new-password" minlength="8" required />
                    </div>
                    <div class="flex justify-end border-t border-base-300 pt-5"><x-submit label="Update password"
                            processing="Updating…" /></div>
                </x-form>
            </div>
        </section>
    </div>
</x-layouts.app>
