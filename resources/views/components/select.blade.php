@props([
    'name',
    'id' => null,
    'label' => null,
    'options' => [],
    'selected' => null,
    'placeholder' => null,
    'required' => false,
    'disabled' => false,
    'help' => null,
])

@php
    $selectId = $id ?? $name;
    $hasError = errors()->has($name);
    $currentValue = old($name, $selected);
@endphp

<div class="form-control w-full mb-3">
    @if ($label)
        <x-label :for="$selectId" :value="$label" :required="$required" />
    @endif

    <select name="{{ $name }}" id="{{ $selectId }}" @required($required) @disabled($disabled)
        {{ $attributes->class([
            'select select-bordered w-full transition-colors',
            'select-error border-error focus:border-error focus:ring-error' => $hasError,
            'focus:border-primary focus:ring-primary' => !$hasError,
        ]) }}>
        @if ($placeholder)
            <option value="" disabled @selected($currentValue === null || $currentValue === '')>
                {{ $placeholder }}
            </option>
        @endif

        @if (!empty($options))
            @foreach ($options as $key => $optionLabel)
                @php
                    $val = is_int($key) ? $optionLabel : $key;
                @endphp
                <option value="{{ $val }}" @selected((string) $currentValue === (string) $val)>
                    {{ $optionLabel }}
                </option>
            @endforeach
        @endif

        {{ $slot }}
    </select>

    @if ($help && !$hasError)
        <x-help :text="$help" />
    @endif

    <x-error :field="$name" />
</div>
