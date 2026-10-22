@props([
    'icon' => 'search',
    'title' => 'No records found',
    'description' => null,
])

<div {{ $attributes->class(['flex flex-col items-center justify-center text-center px-6 py-16']) }}>
    <div class="icon-tile w-12! h-12! mb-5">
        <x-icon :name="$icon" size="lg" />
    </div>

    <h3 class="text-sm font-semibold text-base-content">{{ $title }}</h3>

    @if ($description)
        <p class="text-[13px] muted leading-6 max-w-72 mt-2">{{ $description }}</p>
    @endif

    @if (!empty(trim($slot)))
        <div class="mt-4">
            {{ $slot }}
        </div>
    @endif
</div>
