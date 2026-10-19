@props([
    'variant' => 'neutral',
    'size' => 'sm',
    'outline' => false,
])

@php
    $variantClasses = [
        'primary' => 'badge-primary',
        'secondary' => 'badge-secondary',
        'accent' => 'badge-accent',
        'neutral' => 'badge-neutral',
        'ghost' => 'badge-ghost',
        'info' => 'badge-info',
        'success' => 'badge-success',
        'warning' => 'badge-warning',
        'error' => 'badge-error',
    ];

    $sizeClasses = [
        'xs' => 'badge-xs',
        'sm' => 'badge-sm',
        'md' => 'badge-md',
        'lg' => 'badge-lg',
    ];
@endphp

<span {{ $attributes->class([
    'badge font-medium inline-flex items-center gap-1',
    $variantClasses[$variant] ?? 'badge-neutral',
    $sizeClasses[$size] ?? 'badge-sm',
    'badge-outline' => (bool) $outline,
]) }}>
    {{ $slot }}
</span>
