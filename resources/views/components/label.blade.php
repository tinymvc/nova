@props([
    'for' => null,
    'value' => null,
    'required' => false,
])

<label @if($for) for="{{ $for }}" @endif {{ $attributes->class(['label py-1 block text-sm font-medium text-base-content']) }}>
    <span class="label-text flex items-center gap-1 font-semibold">
        {{ $value ?? $slot }}
        @if($required)
            <span class="text-error font-bold" title="Required">*</span>
        @endif
    </span>
</label>
