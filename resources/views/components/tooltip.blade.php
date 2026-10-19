@props([
    'text',
    'position' => 'top',
])

@php
    $positionClasses = [
        'top' => 'tooltip-top',
        'bottom' => 'tooltip-bottom',
        'left' => 'tooltip-left',
        'right' => 'tooltip-right',
    ];
@endphp

<div data-tip="{{ $text }}" {{ $attributes->class([
    'tooltip',
    $positionClasses[$position] ?? 'tooltip-top',
]) }}>
    {{ $slot }}
</div>
