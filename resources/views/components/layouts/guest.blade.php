@props([
    'title' => config('app.name', 'Nova'),
])
<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }} - {{ config('app.name', 'Nova') }}</title>
    @vite('app.js')
</head>
<body class="min-h-screen bg-base-200/50 text-base-content font-sans antialiased flex flex-col justify-between selection:bg-primary selection:text-primary-content">

    {{-- Top Navbar --}}
    <header class="navbar bg-base-100 border-b border-base-200 px-4 lg:px-8 sticky top-0 z-30 backdrop-blur-md bg-base-100/90">
        <div class="navbar-start">
            <a href="/" class="flex items-center gap-2.5 font-bold text-xl tracking-tight text-base-content hover:opacity-90 transition-opacity">
                <div class="w-9 h-9 rounded-xl bg-primary text-primary-content flex items-center justify-center font-black shadow-md shadow-primary/20">
                    N
                </div>
                <span>Nova</span>
                <span class="badge badge-primary badge-sm font-semibold">Spark</span>
            </a>
        </div>

        <div class="navbar-end flex items-center gap-2">
            @auth
                <a href="{{ route('dashboard') }}" class="btn btn-primary btn-sm gap-1.5" x-navigate>
                    <x-icon name="dashboard" size="xs" />
                    <span>Dashboard</span>
                </a>
            @else
                <a href="{{ route('login') }}" class="btn btn-ghost btn-sm" x-navigate>
                    Sign In
                </a>
                <a href="{{ route('register') }}" class="btn btn-primary btn-sm" x-navigate>
                    Get Started
                </a>
            @endauth
        </div>
    </header>

    {{-- Main Content Container for FireLine (#app > div) --}}
    <main id="app" class="flex-1">
        <div class="w-full">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 lg:py-12">
                <x-flash />
                {{ $slot }}
            </div>
        </div>
    </main>

    {{-- Footer --}}
    <footer class="footer footer-center p-6 bg-base-100 text-base-content/70 border-t border-base-200 text-xs">
        <aside>
            <p>© {{ now()->year }} Nova Starter Kit. Built with <span class="font-semibold text-base-content">TinyMVC / Spark</span> & <span class="font-semibold text-base-content">daisyUI</span>.</p>
        </aside>
    </footer>

</body>
</html>
