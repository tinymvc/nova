@props([
    'name',
    'id' => null,
    'label' => null,
    'value' => '1',
    'checked' => false,
    'disabled' => false,
    'help' => null,
])

@php
    $inputId = $id ?? ($name . '_' . $value);
    $isChecked = old($name) !== null ? (old($name) == $value) : (bool) $checked;
@endphp

<div class="form-control mb-2">
    <label for="{{ $inputId }}" class="label cursor-pointer justify-start gap-3 py-1">
        <input
            type="checkbox"
            name="{{ $name }}"
            id="{{ $inputId }}"
            value="{{ $value }}"
            @checked($isChecked)
            @disabled($disabled)
            {{ $attributes->class(['toggle toggle-primary toggle-sm transition-colors']) }}
        />
        @if($label)
            <span class="label-text select-none text-sm font-medium text-base-content">{{ $label }}</span>
        @endif
    </label>

    @if($help)
        <div class="pl-12">
            <x-help :text="$help" />
        </div>
    @endif

    <x-error :field="$name" class="pl-12" />
</div>
