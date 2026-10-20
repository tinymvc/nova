@props([
    'type' => 'info',
    'message' => null,
    'dismissible' => false,
    'icon' => null,
])

@php
    $typeClasses = [
        'info' => 'alert-info text-info-content',
        'success' => 'alert-success text-success-content',
        'warning' => 'alert-warning text-warning-content',
        'error' => 'alert-error text-error-content',
    ];

    $defaultIcons = [
        'info' => 'info-circle',
        'success' => 'check',
        'warning' => 'alert-triangle',
        'error' => 'alert-circle',
    ];

    $iconName = $icon ?? ($defaultIcons[$type] ?? 'info-circle');
@endphp

<div role="alert"
    @if ($dismissible) x-data="{ dismissed: false }" x-show="!dismissed" x-transition.opacity @endif
    {{ $attributes->class([
        'alert rounded-lg shadow-xs py-3 px-4 flex items-center justify-between text-sm',
        $typeClasses[$type] ?? 'alert-info',
    ]) }}>
    <div class="flex items-center gap-3">
        <x-icon :name="$iconName" size="md" class="shrink-0" />
        <div>
            {{ $message ?? $slot }}
        </div>
    </div>

    @if ($dismissible)
        <button type="button" @click="dismissed = true"
            class="btn btn-ghost btn-xs btn-circle ml-2 opacity-70 hover:opacity-100" aria-label="Close">
            <x-icon name="x-mark" size="xs" />
        </button>
    @endif
</div>
