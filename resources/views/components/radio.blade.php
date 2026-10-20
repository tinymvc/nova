@props(['name', 'id' => null, 'label' => null, 'value' => '', 'checked' => false, 'disabled' => false])

@php
    $inputId = $id ?? $name . '_' . $value;
    $isChecked = old($name) !== null ? old($name) == $value : (bool) $checked;
@endphp

<div class="form-control mb-1">
    <label for="{{ $inputId }}" class="label cursor-pointer justify-start gap-3 py-1">
        <input type="radio" name="{{ $name }}" id="{{ $inputId }}" value="{{ $value }}"
            @checked($isChecked) @disabled($disabled)
            {{ $attributes->class(['radio radio-primary radio-sm transition-colors']) }} />
        @if ($label)
            <span class="label-text select-none text-sm font-medium text-base-content">{{ $label }}</span>
        @endif
    </label>
</div>
