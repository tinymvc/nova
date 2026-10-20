@props([
    'href' => '#',
    'variant' => 'primary',
    'external' => false,
    'icon' => null,
    'navigate' => false,
])

@php
    $variantClasses = [
        'primary' => 'link-primary',
        'secondary' => 'link-secondary',
        'accent' => 'link-accent',
        'neutral' => 'link-neutral',
        'success' => 'text-success-content',
        'warning' => 'text-warning-content',
        'error' => 'text-error-content',
        'hover' => 'link-hover',
    ];

    $classes = [
        'link font-medium inline-flex items-center gap-1.5 transition-colors underline-offset-4',
        $variantClasses[$variant] ?? 'link-primary',
    ];
@endphp

<a href="{{ $href }}" {{ $attributes->class($classes) }}
    @if ($external) target="_blank" rel="noopener noreferrer" @endif
    @if ($navigate) x-navigate @endif>
    @if ($icon)
        <x-icon :name="$icon" size="sm" />
    @endif
    {{ $slot }}
    @if ($external)
        <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 opacity-70" fill="none" viewBox="0 0 24 24"
            stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
        </svg>
    @endif
</a>
