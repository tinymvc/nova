@props([
    'text' => null,
])

<p {{ $attributes->class(['text-xs muted mt-2 leading-5']) }}>
    {{ $text ?? $slot }}
</p>
