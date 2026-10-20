@props([
    'title' => null,
    'subtitle' => null,
    'bordered' => true,
    'shadow' => 'none',
    'bodyClass' => '',
])

@php
    $shadowClasses = [
        'none' => '',
        'sm' => 'shadow-sm',
        'md' => 'shadow-md',
        'lg' => 'shadow-lg',
        'xl' => 'shadow-xl',
    ];
@endphp

<div
    {{ $attributes->class([
        'card bg-base-100 rounded-xl',
        'border border-base-300' => (bool) $bordered,
        $shadowClasses[$shadow] ?? 'shadow-sm',
    ]) }}>
    <div class="card-body p-6 {{ $bodyClass }}">
        @if ($title || $subtitle)
            <div class="mb-4">
                @if ($title)
                    <h3 class="text-sm font-semibold text-base-content">{{ $title }}</h3>
                @endif
                @if ($subtitle)
                    <p class="text-[13px] muted mt-1">{{ $subtitle }}</p>
                @endif
            </div>
        @endif

        {{ $slot }}
    </div>
</div>
