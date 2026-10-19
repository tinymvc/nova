@props([
    'label' => null,
    'vertical' => false,
])

<div {{ $attributes->class(['divider', 'divider-horizontal' => (bool) $vertical, 'my-4 text-xs font-medium uppercase tracking-wider text-base-content/60']) }}>
    {{ $label ?? $slot }}
</div>
