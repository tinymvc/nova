@props(['field' => null, 'message' => null])
<div {{ $attributes->class(['text-xs text-error-content mt-2']) }} aria-live="polite">
    @if ($message)
        <p>{{ $message }}</p>
    @endif
    @if ($field)
        @error($field)
            <p x-show="!$data.form?.status">{{ $message }}</p>
        @enderror
        <p x-cloak x-show="$data.form?.hasError({{ json_encode($field) }})"
            x-text="$data.form?.firstError({{ json_encode($field) }})"></p>
    @endif
</div>
