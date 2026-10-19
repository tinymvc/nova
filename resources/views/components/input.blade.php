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
    $hasError = errors()->has($name);
    $inputValue = old($name, $value);
@endphp

<div class="form-control w-full mb-3" @if($type === 'password') x-data="{ showPassword: false }" @endif>
    @if($label)
        <x-label :for="$inputId" :value="$label" :required="$required" />
    @endif

    <div class="relative w-full">
        @if($icon)
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-base-content/50">
                <x-icon :name="$icon" size="sm" />
            </div>
        @endif

        <input
            :type="@if($type === 'password') showPassword ? 'text' : 'password' @else '{{ $type }}' @endif"
            name="{{ $name }}"
            id="{{ $inputId }}"
            value="{{ $inputValue }}"
            @if($placeholder) placeholder="{{ $placeholder }}" @endif
            @required($required)
            @disabled($disabled)
            @readonly($readonly)
            {{ $attributes->class([
                'input input-bordered w-full transition-colors',
                'pl-10' => (bool) $icon,
                'pr-10' => $type === 'password',
                'input-error border-error focus:border-error focus:ring-error' => $hasError,
                'focus:border-primary focus:ring-primary' => !$hasError,
            ]) }}
        />

        @if($type === 'password')
            <button
                type="button"
                @click="showPassword = !showPassword"
                class="absolute inset-y-0 right-0 pr-3 flex items-center text-base-content/50 hover:text-base-content focus:outline-none"
                tabindex="-1"
                :title="showPassword ? 'Hide password' : 'Show password'"
            >
                <span x-show="!showPassword">
                    <x-icon name="eye" size="sm" />
                </span>
                <span x-show="showPassword" style="display: none;">
                    <x-icon name="eye-slash" size="sm" />
                </span>
            </button>
        @endif
    </div>

    @if($help && !$hasError)
        <x-help :text="$help" />
    @endif

    <x-error :field="$name" />
</div>
