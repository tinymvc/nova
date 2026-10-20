@props([
    'name',
    'id' => null,
    'label' => null,
    'value' => null,
    'rows' => 4,
    'placeholder' => null,
    'required' => false,
    'disabled' => false,
    'readonly' => false,
    'help' => null,
])

@php
    $inputId = $id ?? $name;
    $hasError = errors()->has($name);
    $inputValue = old($name, $value);
@endphp

<div class="w-full">
    @if ($label)
        <x-label :for="$inputId" :value="$label" :required="$required" />
    @endif

    <textarea name="{{ $name }}" id="{{ $inputId }}" rows="{{ $rows }}"
        @if ($placeholder) placeholder="{{ $placeholder }}" @endif @required($required)
        @disabled($disabled) @readonly($readonly)
        aria-describedby="{{ $inputId }}-error{{ $help ? ' ' . $inputId . '-help' : '' }}"
        aria-invalid="{{ $hasError ? 'true' : 'false' }}"
        :aria-invalid="$data.form?.status ? !!$data.form?.hasError({{ json_encode($name) }}) : {{ $hasError ? 'true' : 'false' }}"
        {{ $attributes->class(['textarea w-full']) }}>{{ $inputValue }}</textarea>

    @if ($help)
        <x-help :text="$help" :id="$inputId . '-help'" />
    @endif

    <x-error :field="$name" :id="$inputId . '-error'" />
</div>
