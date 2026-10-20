@props(['id', 'title' => null, 'maxWidth' => 'md'])

@php
    $maxWidthClasses = [
        'sm' => 'max-w-sm',
        'md' => 'max-w-md',
        'lg' => 'max-w-lg',
        'xl' => 'max-w-xl',
        '2xl' => 'max-w-2xl',
        '3xl' => 'max-w-3xl',
        '4xl' => 'max-w-4xl',
        '5xl' => 'max-w-5xl',
    ];
@endphp

<dialog id="{{ $id }}" @if ($title) aria-labelledby="{{ $id }}-title" @endif
    {{ $attributes->class(['modal modal-bottom sm:modal-middle']) }} x-data
    @open-modal.window="if ($event.detail === '{{ $id }}') $el.showModal()"
    @close-modal.window="if ($event.detail === '{{ $id }}') $el.close()">
    <div class="modal-box {{ $maxWidthClasses[$maxWidth] ?? 'max-w-md' }} p-6 relative">
        <form method="dialog">
            <button class="btn btn-sm btn-square btn-ghost absolute right-3 top-3 muted" aria-label="Close">
                <x-icon name="x-mark" size="sm" />
            </button>
        </form>

        @if ($title)
            <h2 id="{{ $id }}-title" class="text-lg font-semibold tracking-tight mb-2 pr-8">{{ $title }}
            </h2>
        @endif

        <div class="modal-content">
            {{ $slot }}
        </div>
    </div>

    <form method="dialog" class="modal-backdrop">
        <button aria-label="Close backdrop">close</button>
    </form>
</dialog>
