@props(['title', 'description' => null])

<div {{ $attributes->class(['flex flex-col sm:flex-row sm:items-center sm:justify-between gap-5 mb-8']) }}>
    <div>
        <h1 data-page-heading tabindex="-1" class="page-title">{{ $title }}</h1>
        @if ($description)
            <p class="mt-2 text-sm muted">{{ $description }}</p>
        @endif
    </div>

    @if (!empty(trim($slot)))
        <div class="flex items-center gap-2.5 flex-wrap">
            {{ $slot }}
        </div>
    @endif
</div>
