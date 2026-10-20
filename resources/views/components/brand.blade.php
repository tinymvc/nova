@props(['href' => '/', 'compact' => false])
<a href="{{ $href }}" {{ $attributes->class(['inline-flex items-center gap-2.5 shrink-0']) }} x-navigate
    aria-label="Nova home">
    <svg width="30" height="30" viewBox="0 0 32 32" fill="none" aria-hidden="true">
        <rect width="32" height="32" rx="9" fill="#635bce" />
        <path d="M9 23V9h3l8 10V9h3v14h-3L12 13v10H9Z" fill="white" />
    </svg>
    @if (!$compact)
        <span class="text-xl font-semibold tracking-[-0.045em]">nova<span class="text-primary">.</span></span>
    @endif
</a>
