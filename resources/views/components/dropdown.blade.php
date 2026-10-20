@props([
    'align' => 'end',
    'contentClass' => 'w-52',
])

@php
    $alignClass = $align === 'start' ? 'dropdown-start' : 'dropdown-end';
@endphp

<div {{ $attributes->class(['dropdown', $alignClass, 'relative inline-block']) }} x-data="{ open: false }"
    @click.outside="open = false" @keydown.escape.window="open = false">
    <div @click="open = !open">
        {{ $slot }}
    </div>

    <ul x-show="open" x-transition:enter="transition ease-out duration-100"
        x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100"
        x-transition:leave-end="transform opacity-0 scale-95"
        class="dropdown-content menu p-1.5 shadow-md shadow-neutral/10 bg-base-100 rounded-lg border border-base-300 z-50 {{ $contentClass }} mt-2"
        style="display: none;">
        @if (isset($items))
            {{ $items }}
        @endif
    </ul>
</div>
