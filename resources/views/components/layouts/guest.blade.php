<div {{ $attributes->class(['min-h-svh flex flex-col']) }}>
    <header class="w-full max-w-6xl mx-auto flex h-20 items-center justify-end px-6 lg:px-8">
        <nav aria-label="Main navigation" class="flex items-center gap-2">
            @auth
                <a href="{{ route('dashboard') }}" class="btn btn-outline btn-sm" x-navigate>
                    Dashboard <x-icon name="arrow-right" size="sm" />
                </a>
            @else
                <a href="{{ route('login') }}" class="btn btn-ghost btn-sm" x-navigate>Sign in</a>
                <a href="{{ route('register') }}" class="btn btn-outline btn-sm" x-navigate>Register</a>
            @endauth
        </nav>
    </header>
    <main id="main-content" class="flex-1 flex items-center justify-center px-6 py-12">{{ $slot }}</main>
</div>
