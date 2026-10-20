@props([
    'items' => [],
])

@if (!empty($items))
    <nav aria-label="Breadcrumb" {{ $attributes->class(['breadcrumbs text-[13px] muted']) }}>
        <ol>
            @foreach ($items as $index => $item)
                <li>
                    @if (!empty($item['url']) && $index < count($items) - 1)
                        <a href="{{ $item['url'] }}" x-navigate class="hover:text-primary transition-colors">
                            @if (!empty($item['icon']))
                                <x-icon :name="$item['icon']" size="sm" class="mr-1" />
                            @endif
                            {{ $item['label'] }}
                        </a>
                    @else
                        <span aria-current="page" class="text-base-content">
                            @if (!empty($item['icon']))
                                <x-icon :name="$item['icon']" size="sm" class="mr-1" />
                            @endif
                            {{ $item['label'] }}
                        </span>
                    @endif
                </li>
            @endforeach
        </ol>
    </nav>
@endif
