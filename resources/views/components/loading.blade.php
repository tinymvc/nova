@props([
    'type' => 'spinner',
    'size' => 'md',
    'color' => null,
])

@php
    $typeClasses = [
        'spinner' => 'loading-spinner',
        'dots' => 'loading-dots',
        'ring' => 'loading-ring',
        'ball' => 'loading-ball',
        'bars' => 'loading-bars',
        'infinity' => 'loading-infinity',
    ];

    $sizeClasses = [
        'xs' => 'loading-xs',
        'sm' => 'loading-sm',
        'md' => 'loading-md',
        'lg' => 'loading-lg',
    ];

    $colorClasses = [
        'primary' => 'text-primary',
        'secondary' => 'text-secondary',
        'accent' => 'text-accent',
        'neutral' => 'text-neutral',
        'info' => 'text-info',
        'success' => 'text-success',
        'warning' => 'text-warning',
        'error' => 'text-error',
    ];
@endphp

<span {{ $attributes->class([
    'loading',
    $typeClasses[$type] ?? 'loading-spinner',
    $sizeClasses[$size] ?? 'loading-md',
    $color ? ($colorClasses[$color] ?? '') : '',
]) }}></span>
