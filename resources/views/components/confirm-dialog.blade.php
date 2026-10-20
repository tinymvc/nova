@props([
    'id',
    'title' => 'Confirm Action',
    'message' => 'Are you sure you want to proceed? This action cannot be undone.',
    'confirmText' => 'Confirm',
    'cancelText' => 'Cancel',
    'action' => '#',
    'method' => 'POST',
    'variant' => 'error',
])

@php
    $btnVariant = 'btn-' . $variant;
@endphp

<x-modal :id="$id" :title="$title" maxWidth="sm">
    <p class="text-sm text-base-content/70 mb-6">{{ $message }}</p>

    <div class="flex items-center justify-end gap-3">
        <form method="dialog">
            <x-button type="submit" variant="ghost" size="sm">
                {{ $cancelText }}
            </x-button>
        </form>

        <form action="{{ $action }}" method="POST">
            @csrf
            @if (in_array(strtoupper($method), ['PUT', 'PATCH', 'DELETE']))
                @method($method)
            @endif

            <x-button type="submit" :variant="$variant" size="sm">
                {{ $confirmText }}
            </x-button>
        </form>
    </div>
</x-modal>
