@props(['title'])
<x-layouts.fire :$title>
    <div {{ $attributes->class(['min-h-svh flex items-center justify-center px-6 py-12']) }}>
        <main id="main-content" class="w-full max-w-95">
            <div class="flex justify-center mb-9"><x-brand :stacked="true" /></div>
            <x-flash />
            {{ $slot }}
        </main>
    </div>
</x-layouts.fire>
