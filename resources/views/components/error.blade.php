@props([
    'field' => null,
    'message' => null,
])

@if($message)
    <p {{ $attributes->class(['text-xs text-error font-medium mt-1 flex items-center gap-1']) }} role="alert">
        <x-icon name="alert-circle" size="xs" />
        {{ $message }}
    </p>
@elseif($field)
    @error($field)
        <p {{ $attributes->class(['text-xs text-error font-medium mt-1 flex items-center gap-1']) }} role="alert">
            <x-icon name="alert-circle" size="xs" />
            {{ $message }}
        </p>
    @enderror
@endif
