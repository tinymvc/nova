@props([
    'src' => null,
    'name' => null,
    'size' => 'md',
    'shape' => 'circle',
    'status' => null,
])

@php
    $sizeClasses = [
        'xs' => 'w-6 h-6 text-[10px]',
        'sm' => 'w-8 h-8 text-xs',
        'md' => 'w-10 h-10 text-sm',
        'lg' => 'w-14 h-14 text-lg',
        'xl' => 'w-20 h-20 text-2xl',
    ];

    $shapeClasses = [
        'circle' => 'rounded-full',
        'squircle' => 'rounded-2xl',
        'rounded' => 'rounded-lg',
        'square' => 'rounded-none',
    ];

    $statusClasses = [
        'online' => 'online',
        'offline' => 'offline',
    ];

    // Compute initials from name
    $initials = '';
    if (!empty($name)) {
        $words = preg_split('/\s+/', trim($name));
        $initials = mb_substr($words[0] ?? '', 0, 1);
        if (count($words) > 1) {
            $initials .= mb_substr(end($words), 0, 1);
        }
        $initials = strtoupper($initials);
    }
@endphp

<div {{ $attributes->class([
    'avatar select-none',
    ($status ? ($statusClasses[$status] ?? '') : ''),
    'placeholder' => empty($src),
]) }}>
    <div class="{{ $sizeClasses[$size] ?? $sizeClasses['md'] }} {{ $shapeClasses[$shape] ?? 'rounded-full' }} {{ empty($src) ? 'bg-primary text-primary-content font-bold' : '' }}">
        @if(!empty($src))
            <img src="{{ $src }}" alt="{{ $name ?? 'Avatar' }}" loading="lazy" />
        @else
            <span>{{ $initials ?: '?' }}</span>
        @endif
    </div>
</div>
