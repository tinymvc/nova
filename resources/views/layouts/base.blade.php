<!DOCTYPE html>
<html lang="en" data-theme="nova">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#f6f6f4">
    <meta name="description" content="Nova — a thoughtful starting point for your next TinyMVC / Spark application.">
    <title>@yield('title')</title>
    <link rel="icon" href="/favicon.svg" type="image/svg+xml">
    @vite('app.js')
</head>

<body class="bg-base-100 text-base-content">
    <a href="#main-content"
        class="sr-only focus:not-sr-only focus:fixed focus:top-3 focus:left-3 focus:z-[100] btn btn-primary">Skip to
        content</a>
    <div id="app">@yield('content')</div>
    <noscript>
        <p class="px-6 py-3 text-center text-sm muted">JavaScript adds instant navigation and dialogs. Account forms
            also work with standard browser navigation.</p>
    </noscript>
</body>

</html>
