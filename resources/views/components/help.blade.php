@props([
    'text' => null,
])

<p {{ $attributes->class(['text-xs text-base-content/60 mt-1']) }}>
    {{ $text ?? $slot }}
</p>
