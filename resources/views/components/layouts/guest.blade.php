<div {{ $attributes }}>
    <header class="max-w-6xl mx-auto flex h-24 items-center justify-between px-6 lg:px-8">
        <x-brand />
        <nav aria-label="Main navigation" class="flex items-center gap-2 sm:gap-5 text-sm">
            <a class="muted hover:text-base-content hidden sm:inline" href="https://github.com/tinymvc/tinycore"
                target="_blank" rel="noopener noreferrer">GitHub <span aria-hidden="true">↗</span></a>
            @auth
                <a href="{{ route('dashboard') }}" class="btn btn-primary btn-sm" x-navigate>Open dashboard <x-icon
                        name="arrow-right" size="sm" /></a>
            @else
                <a href="{{ route('login') }}" class="btn btn-ghost btn-sm" x-navigate>Sign in</a>
                <a href="{{ route('register') }}" class="btn btn-primary btn-sm" x-navigate>Get started <x-icon
                        name="arrow-right" size="sm" /></a>
            @endauth
        </nav>
    </header>
    <main id="main-content">{{ $slot }}</main>
    <footer
        class="max-w-6xl mx-auto px-6 lg:px-8 py-8 border-t border-base-300 flex flex-col sm:flex-row gap-3 justify-between text-xs muted">
        <p>A thoughtful starting point. Built with TinyMVC / Spark.</p>
        <p>Open source. Yours to make.</p>
    </footer>
</div>
