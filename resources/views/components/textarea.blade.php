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

<div class="form-control w-full mb-3">
    @if ($label)
        <x-label :for="$inputId" :value="$label" :required="$required" />
    @endif

    <textarea name="{{ $name }}" id="{{ $inputId }}" rows="{{ $rows }}"
        @if ($placeholder) placeholder="{{ $placeholder }}" @endif @required($required)
        @disabled($disabled) @readonly($readonly)
        {{ $attributes->class([
            'textarea textarea-bordered w-full transition-colors',
            'textarea-error border-error focus:border-error focus:ring-error' => $hasError,
            'focus:border-primary focus:ring-primary' => !$hasError,
        ]) }}>{{ $inputValue }}</textarea>

    @if ($help && !$hasError)
        <x-help :text="$help" />
    @endif

    <x-error :field="$name" />
</div>
