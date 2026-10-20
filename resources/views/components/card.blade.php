@props([
    'title' => null,
    'subtitle' => null,
    'bordered' => true,
    'shadow' => 'sm',
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
        'card bg-base-100 transition-all duration-200',
        'card-bordered border-base-200' => (bool) $bordered,
        $shadowClasses[$shadow] ?? 'shadow-sm',
    ]) }}>
    <div class="card-body p-6 {{ $bodyClass }}">
        @if ($title || $subtitle)
            <div class="mb-4">
                @if ($title)
                    <h3 class="card-title text-lg font-bold text-base-content">{{ $title }}</h3>
                @endif
                @if ($subtitle)
                    <p class="text-xs text-base-content/60 mt-0.5">{{ $subtitle }}</p>
                @endif
            </div>
        @endif

        {{ $slot }}
    </div>
</div>
