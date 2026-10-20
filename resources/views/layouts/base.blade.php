<!DOCTYPE html>
<html lang="en" data-theme="spark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#ffffff">
    <meta name="description" content="Spark by TinyMVC — simple tools, clean code, real projects.">
    <title>@yield('title')</title>
    <link rel="icon" href="/favicon.svg" type="image/svg+xml">
    @vite(['app.js', 'app.css'])
</head>

<body class="bg-base-100 text-base-content" x-data>
    <a href="#main-content"
        class="sr-only focus:not-sr-only focus:fixed focus:top-3 focus:left-3 focus:z-100 btn btn-primary">Skip to
        content</a>
    <div id="app">@yield('content')</div>
    <noscript>
        <p class="px-6 py-3 text-center text-sm muted">JavaScript adds instant navigation and dialogs. Account forms
            also work with standard browser navigation.</p>
    </noscript>
</body>

</html>
