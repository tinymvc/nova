@extends('layouts.guest')
@section('title', 'Welcome to Nova')

@section('content')
    <div class="py-12 lg:py-20 text-center max-w-3xl mx-auto">
        <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-primary/10 text-primary text-xs font-semibold mb-6">
            <span class="w-2 h-2 rounded-full bg-primary animate-pulse"></span>
            Production-Ready TinyMVC Starter Kit
        </div>

        <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold tracking-tight text-base-content leading-tight mb-6">
            Craft modern web applications with <span class="text-primary">Nova & Spark</span>.
        </h1>

        <p class="text-lg text-base-content/70 mb-10 leading-relaxed max-w-2xl mx-auto">
            A clean, lightweight, battery-included starter kit for TinyMVC / Spark. Featuring Tailwind CSS 4, daisyUI 5, Alpine.js 3, and FireLine 2.1.
        </p>

        <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
            @auth
                <a href="{{ route('dashboard') }}" class="btn btn-primary btn-md px-8 shadow-lg shadow-primary/25" x-navigate>
                    <x-icon name="dashboard" size="sm" />
                    <span>Go to Dashboard</span>
                </a>
            @else
                <a href="{{ route('register') }}" class="btn btn-primary btn-md px-8 shadow-lg shadow-primary/25" x-navigate>
                    <span>Get Started Free</span>
                    <x-icon name="arrow-right" size="sm" />
                </a>
                <a href="{{ route('login') }}" class="btn btn-outline btn-md px-8" x-navigate>
                    Sign In to Account
                </a>
            @endauth
        </div>
    </div>

    {{-- Feature Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 my-16">
        <x-card title="Blade Components" subtitle="Component-First UI" class="hover:border-primary/50 transition-colors">
            <p class="text-sm text-base-content/70">
                Over 20 pre-built accessible components including buttons, form inputs, modals, alerts, tables, and pagination.
            </p>
        </x-card>

        <x-card title="Secure Authentication" subtitle="Built-in Security" class="hover:border-primary/50 transition-colors">
            <p class="text-sm text-base-content/70">
                Session fixation protection, rate-limited login, secure password hashing, and expiring single-use password resets.
            </p>
        </x-card>

        <x-card title="Tailwind 4 & daisyUI 5" subtitle="Modern Styling Stack" class="hover:border-primary/50 transition-colors">
            <p class="text-sm text-base-content/70">
                Supercharged by Vite 7 with semantic design tokens, instant hot reloading, and zero bloated configurations.
            </p>
        </x-card>
    </div>
@endsection
