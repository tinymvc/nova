@props(['href' => '/', 'compact' => false, 'stacked' => false])
<a href="{{ $href }}" {{ $attributes->class(['brand', 'brand-stacked' => $stacked]) }} x-navigate
    aria-label="Spark by TinyMVC home">
    <x-icon name="flame" class="brand-flame" />
    @if (!$compact)
        <span class="brand-wordmark">spark
            @if ($stacked)
                <small>BY TINYMVC</small>
            @endif
        </span>
    @endif
</a>
