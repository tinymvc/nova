@props([
    'for' => null,
    'value' => null,
    'required' => false,
])

<label @if ($for) for="{{ $for }}" @endif
    {{ $attributes->class(['field-label text-base-content']) }}>
    <span class="flex items-center gap-1">
        {{ $value ?? $slot }}
        @if ($required)
            <span class="text-error-content" title="Required">*</span>
        @endif
    </span>
</label>
