@props([
    'type' => 'rectangle',
    'count' => 1,
])

@php
    $typeClasses = [
        'rectangle' => 'h-32 w-full rounded-xl',
        'card' => 'h-48 w-full rounded-2xl',
        'circle' => 'w-12 h-12 rounded-full shrink-0',
        'avatar' => 'w-10 h-10 rounded-full shrink-0',
        'title' => 'h-6 w-3/4 rounded-md',
        'text' => 'h-4 w-full rounded-md',
        'button' => 'h-10 w-24 rounded-lg',
    ];
@endphp

@for($i = 0; $i < $count; $i++)
    <div {{ $attributes->class([
        'skeleton animate-pulse bg-base-300/60',
        $typeClasses[$type] ?? 'h-32 w-full rounded-xl',
        'mb-2' => $count > 1,
    ]) }}></div>
@endfor
