@props([
    'type' => 'button',
    'variant' => 'primary',
    'size' => 'md',
    'loading' => false,
    'icon' => null,
    'outline' => false,
    'disabled' => false,
])

@php
    $variantClasses = [
        'primary' => 'btn-primary',
        'secondary' => 'btn-secondary',
        'accent' => 'btn-accent',
        'neutral' => 'btn-neutral',
        'ghost' => 'btn-ghost',
        'link' => 'btn-link',
        'error' => 'btn-error',
        'warning' => 'btn-warning',
        'success' => 'btn-success',
        'info' => 'btn-info',
    ];

    $sizeClasses = [
        'xs' => 'btn-xs',
        'sm' => 'btn-sm',
        'md' => 'btn-md',
        'lg' => 'btn-lg',
    ];

    $classes = [
        'btn',
        $variantClasses[$variant] ?? 'btn-primary',
        $sizeClasses[$size] ?? 'btn-md',
        'btn-outline' => (bool) $outline,
        'gap-2',
    ];
@endphp

<button
    type="{{ $type }}"
    {{ $attributes->class($classes) }}
    @disabled($disabled || $loading)
>
    @if($loading)
        <span class="loading loading-spinner {{ $size === 'xs' ? 'loading-xs' : 'loading-sm' }}"></span>
    @elseif($icon)
        <x-icon :name="$icon" :size="$size === 'xs' ? 'xs' : 'sm'" />
    @endif

    {{ $slot }}
</button>
