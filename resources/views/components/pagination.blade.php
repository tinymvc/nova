@props([
    'paginator',
])

@if(isset($paginator) && $paginator->hasPages())
    <div {{ $attributes->class(['flex flex-col sm:flex-row items-center justify-between gap-4 py-3']) }}>
        <div class="text-xs text-base-content/70">
            Showing <span class="font-semibold text-base-content">{{ $paginator->firstItem() }}</span> to <span class="font-semibold text-base-content">{{ $paginator->lastItem() }}</span> of <span class="font-semibold text-base-content">{{ $paginator->total() }}</span> results
        </div>

        <div class="join">
            {{-- Previous Page Link --}}
            @if($paginator->onFirstPage())
                <button class="join-item btn btn-sm btn-disabled" disabled aria-label="Previous">
                    <x-icon name="chevron-left" size="xs" />
                </button>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" class="join-item btn btn-sm" aria-label="Previous" x-navigate>
                    <x-icon name="chevron-left" size="xs" />
                </a>
            @endif

            {{-- Numbered Page Links --}}
            @php
                $current = $paginator->currentPage();
                $last = $paginator->lastPage();
                $start = max(1, $current - 2);
                $end = min($last, $current + 2);
            @endphp

            @if($start > 1)
                <a href="{{ $paginator->url(1) }}" class="join-item btn btn-sm" x-navigate>1</a>
                @if($start > 2)
                    <button class="join-item btn btn-sm btn-disabled" disabled>...</button>
                @endif
            @endif

            @for($page = $start; $page <= $end; $page++)
                @if($page == $current)
                    <button class="join-item btn btn-sm btn-primary" aria-current="page">{{ $page }}</button>
                @else
                    <a href="{{ $paginator->url($page) }}" class="join-item btn btn-sm" x-navigate>{{ $page }}</a>
                @endif
            @endfor

            @if($end < $last)
                @if($end < $last - 1)
                    <button class="join-item btn btn-sm btn-disabled" disabled>...</button>
                @endif
                <a href="{{ $paginator->url($last) }}" class="join-item btn btn-sm" x-navigate>{{ $last }}</a>
            @endif

            {{-- Next Page Link --}}
            @if($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" class="join-item btn btn-sm" aria-label="Next" x-navigate>
                    <x-icon name="chevron-right" size="xs" />
                </a>
            @else
                <button class="join-item btn btn-sm btn-disabled" disabled aria-label="Next">
                    <x-icon name="chevron-right" size="xs" />
                </button>
            @endif
        </div>
    </div>
@endif
