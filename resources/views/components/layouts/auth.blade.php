<div class="min-h-svh grid lg:grid-cols-[0.95fr_1.05fr]" {{ $attributes }}>
    <aside class="auth-art hidden lg:flex flex-col justify-between p-12 xl:px-16 border-r border-base-300">
        <x-brand />
        <div class="py-10">
            <div class="orbit mx-auto mb-16" aria-hidden="true"><span
                    class="absolute -top-1 left-28 w-3 h-3 rounded-full bg-primary"></span></div>
            <p class="eyebrow mb-5">Room for your next big idea</p>
            <p class="text-4xl xl:text-5xl tracking-[-0.05em] leading-[1.15] max-w-md">Great things start<br>with a
                little <span class="text-primary">spark.</span></p>
            <p class="muted mt-5 text-sm leading-6 max-w-xs">A clean foundation. A familiar stack. Everything you need to
                make it your own.</p>
        </div>
        <p class="text-xs muted">Nova <span class="mx-2 opacity-40">/</span> TinyMVC / Spark</p>
    </aside>
    <main id="main-content" class="flex flex-col min-h-svh px-6 sm:px-12">
        <div class="h-24 flex items-center justify-between lg:justify-end shrink-0">
            <x-brand class="lg:hidden" />
            <a href="{{ route('home') }}" x-navigate
                class="inline-flex items-center gap-2 text-xs muted hover:text-base-content"><x-icon name="arrow-left"
                    size="xs" /> Back to home</a>
        </div>
        <div class="w-full max-w-[390px] mx-auto flex-1 flex flex-col justify-center py-10">
            <x-flash />
            {{ $slot }}
        </div>
        <p class="text-center text-[11px] muted py-7">Made for a fresh start. Built to be yours.</p>
    </main>
</div>
