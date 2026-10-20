@props(['field' => null, 'message' => null])
<div {{ $attributes->class(['text-xs text-error-content']) }} aria-live="polite">
    @if ($message)
        <p class="mt-2">{{ $message }}</p>
    @endif
    @if ($field)
        @error($field)
            <p class="mt-2" x-show="!$data.form?.status">{{ $message }}</p>
        @enderror
        <p class="mt-2" x-cloak x-show="$data.form?.hasError({{ json_encode($field) }})"
            x-text="$data.form?.firstError({{ json_encode($field) }})"></p>
    @endif
</div>
