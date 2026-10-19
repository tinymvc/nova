<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Sign In') - {{ config('app.name', 'Nova') }}</title>
    @vite('app.js')
</head>
<body class="min-h-screen bg-base-200/60 text-base-content font-sans antialiased flex flex-col justify-center items-center p-4 selection:bg-primary selection:text-primary-content">

    <div id="app" class="w-full max-w-md">
        <div>
            {{-- Header Branding --}}
            <div class="text-center mb-8">
                <a href="/" class="inline-flex items-center gap-2.5 font-bold text-2xl tracking-tight text-base-content hover:opacity-90 transition-opacity">
                    <div class="w-10 h-10 rounded-xl bg-primary text-primary-content flex items-center justify-center font-black shadow-lg shadow-primary/25">
                        N
                    </div>
                    <span>Nova</span>
                </a>
                <p class="text-xs text-base-content/60 mt-1 font-medium">TinyMVC / Spark Starter Kit</p>
            </div>

            {{-- Flash Notifications --}}
            <x-flash />

            {{-- Card Container --}}
            <div class="card bg-base-100 shadow-xl border border-base-200/80 rounded-2xl overflow-hidden">
                <div class="card-body p-6 sm:p-8">
                    @yield('content')
                </div>
            </div>

            {{-- Footer info --}}
            <div class="text-center mt-6 text-xs text-base-content/50">
                <p>© {{ now()->year }} Nova. Secure & Fast.</p>
            </div>
        </div>
    </div>

</body>
</html>
