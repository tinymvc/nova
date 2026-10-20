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

<div class="w-full">
    @if ($label)
        <x-label :for="$selectId" :value="$label" :required="$required" />
    @endif

    <select name="{{ $name }}" id="{{ $selectId }}" @required($required) @disabled($disabled)
        aria-describedby="{{ $selectId }}-error{{ $help ? ' ' . $selectId . '-help' : '' }}"
        aria-invalid="{{ $hasError ? 'true' : 'false' }}"
        :aria-invalid="$data.form?.status ? !!$data.form?.hasError({{ json_encode($name) }}) : {{ $hasError ? 'true' : 'false' }}"
        {{ $attributes->class(['select w-full h-11']) }}>
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

    @if ($help)
        <x-help :text="$help" :id="$selectId . '-help'" />
    @endif

    <x-error :field="$name" :id="$selectId . '-error'" />
</div>
