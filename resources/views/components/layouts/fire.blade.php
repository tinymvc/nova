@props(['title'])

@if (is_fire_js())
    @section('title', $title)
    @section('content')
        {{ $slot }}
    @show
@else
    <x-layouts.base :$title>
        {{ $slot }}
    </x-layouts.base>
@endif
