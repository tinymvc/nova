@props(['title', 'description' => null])

<div
    {{ $attributes->class(['flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6 pb-4 border-b border-base-200']) }}>
    <div>
        <h1 class="text-2xl lg:text-3xl font-bold tracking-tight text-base-content">{{ $title }}</h1>
        @if ($description)
            <p class="mt-1 text-sm text-base-content/70">{{ $description }}</p>
        @endif
    </div>

    @if (!empty(trim($slot)))
        <div class="flex items-center gap-2.5 flex-wrap">
            {{ $slot }}
        </div>
    @endif
</div>
