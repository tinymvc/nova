@props([
    'name',
    'id' => null,
    'label' => null,
    'type' => 'text',
    'value' => null,
    'placeholder' => null,
    'required' => false,
    'disabled' => false,
    'readonly' => false,
    'help' => null,
    'icon' => null,
])
@php
    $inputId = $id ?? $name;
    $inputValue = $type === 'password' ? '' : old($name, $value);
    $hasError = errors()->has($name);
@endphp
<div class="w-full" @if ($type === 'password') x-data="{ showPassword: false }" @endif>
    @if ($label)
        <label for="{{ $inputId }}" class="block text-xs font-medium mb-2">{{ $label }}</label>
    @endif
    <div class="relative">
        <input type="{{ $type }}"
            @if ($type === 'password') :type="showPassword ? 'text' : 'password'" @endif
            name="{{ $name }}" id="{{ $inputId }}" value="{{ $inputValue }}"
            @if ($placeholder) placeholder="{{ $placeholder }}" @endif @required($required)
            @disabled($disabled) @readonly($readonly)
            aria-describedby="{{ $inputId }}-error{{ $help ? ' ' . $inputId . '-help' : '' }}"
            aria-invalid="{{ $hasError ? 'true' : 'false' }}"
            :aria-invalid="$data.form?.status ? !!$data.form?.hasError({{ json_encode($name) }}) : {{ $hasError ? 'true' : 'false' }}"
            {{ $attributes->class(['input w-full h-11', 'pr-12' => $type === 'password']) }}>
        @if ($type === 'password')
            <button type="button" @click="showPassword = !showPassword"
                class="absolute inset-y-0 right-0 px-3 muted hover:text-base-content"
                :aria-label="showPassword ? 'Hide password' : 'Show password'" :aria-pressed="showPassword"
                aria-label="Show password">
                <span x-show="!showPassword"><x-icon name="eye" size="sm" /></span>
                <span x-cloak x-show="showPassword"><x-icon name="eye-slash" size="sm" /></span>
            </button>
        @endif
    </div>
    @if ($help)
        <p id="{{ $inputId }}-help" class="text-[11px] muted mt-2 leading-5">{{ $help }}</p>
    @endif
    <x-error :field="$name" :id="$inputId . '-error'" />
</div>
