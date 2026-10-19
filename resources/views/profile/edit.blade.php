@extends('layouts.app')
@section('title', 'Profile Settings')

@section('content')
    <x-breadcrumb :items="[
        ['label' => 'Dashboard', 'url' => route('dashboard'), 'icon' => 'dashboard'],
        ['label' => 'Profile Settings'],
    ]" class="mb-4" />

    <x-page-header title="Profile Settings" description="Update your personal details and manage account security preferences." />

    <div class="space-y-6 max-w-4xl">
        {{-- Profile Information --}}
        <div class="card bg-base-100 border border-base-200 shadow-sm rounded-2xl p-6">
            <div class="mb-4">
                <h3 class="card-title text-lg font-bold text-base-content">Profile Information</h3>
                <p class="text-xs text-base-content/60 mt-0.5">Update your account display name, unique username, and email address.</p>
            </div>

            <form method="POST" action="{{ route('profile.update') }}" class="space-y-4 max-w-xl">
                @csrf
                @method('PATCH')

                <x-input
                    name="name"
                    type="text"
                    label="Full Name"
                    :value="$user->name"
                    icon="user"
                    required
                />

                <x-input
                    name="username"
                    type="text"
                    label="Username"
                    :value="$user->username"
                    icon="user"
                    help="Your public handle across the platform"
                    required
                />

                <x-input
                    name="email"
                    type="email"
                    label="Email Address"
                    :value="$user->email"
                    icon="mail"
                    required
                />

                <div class="pt-2">
                    <x-button type="submit" variant="primary" size="sm">
                        Save Profile Details
                    </x-button>
                </div>
            </form>
        </div>

        {{-- Password Update --}}
        <div class="card bg-base-100 border border-base-200 shadow-sm rounded-2xl p-6">
            <div class="mb-4">
                <h3 class="card-title text-lg font-bold text-base-content">Change Password</h3>
                <p class="text-xs text-base-content/60 mt-0.5">Ensure your account is using a long, random password to stay secure.</p>
            </div>

            <form method="POST" action="{{ route('profile.update') }}" class="space-y-4 max-w-xl">
                @csrf
                @method('PATCH')

                {{-- Hidden fields to preserve existing profile attributes during partial submission --}}
                <input type="hidden" name="name" value="{{ $user->name }}" />
                <input type="hidden" name="username" value="{{ $user->username }}" />
                <input type="hidden" name="email" value="{{ $user->email }}" />

                <x-input
                    name="current_password"
                    type="password"
                    label="Current Password"
                    placeholder="••••••••"
                    icon="lock"
                    required
                />

                <x-input
                    name="password"
                    type="password"
                    label="New Password"
                    placeholder="••••••••"
                    icon="lock"
                    help="Must be at least 8 characters"
                    required
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
                    <x-button type="submit" variant="primary" size="sm">
                        Update Password
                    </x-button>
                </div>
            </form>
        </div>
    </div>
@endsection
