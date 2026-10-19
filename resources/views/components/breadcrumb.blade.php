@props([
    'items' => [],
])

@if(!empty($items))
    <div {{ $attributes->class(['breadcrumbs text-sm text-base-content/70']) }}>
        <ul>
            @foreach($items as $index => $item)
                <li>
                    @if(!empty($item['url']) && $index < count($items) - 1)
                        <a href="{{ $item['url'] }}" class="hover:text-primary transition-colors">
                            @if(!empty($item['icon']))
                                <x-icon :name="$item['icon']" size="sm" class="mr-1" />
                            @endif
                            {{ $item['label'] }}
                        </a>
                    @else
                        <span class="font-medium text-base-content">
                            @if(!empty($item['icon']))
                                <x-icon :name="$item['icon']" size="sm" class="mr-1" />
                            @endif
                            {{ $item['label'] }}
                        </span>
                    @endif
                </li>
            @endforeach
        </ul>
    </div>
@endif
