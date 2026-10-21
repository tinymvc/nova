@props(['title'])

@if (!is_fire_js())
    @extends('layouts.base')
@endif

@section('title', $title)

@section('content')
    {{ $slot }}
@endsection

@if (is_fire_js())
    @yield('content')
@endif
