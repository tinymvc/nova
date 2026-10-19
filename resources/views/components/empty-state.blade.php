@props([
    'icon' => 'search',
    'title' => 'No records found',
    'description' => null,
])

<div {{ $attributes->class(['flex flex-col items-center justify-center text-center p-8 lg:p-12 border-2 border-dashed border-base-300 rounded-2xl bg-base-100/50']) }}>
    <div class="w-14 h-14 rounded-full bg-base-200/80 flex items-center justify-center text-base-content/50 mb-4">
        <x-icon :name="$icon" size="lg" />
    </div>

    <h4 class="text-base font-bold text-base-content">{{ $title }}</h4>

    @if($description)
        <p class="text-sm text-base-content/60 max-w-sm mt-1 mb-5">{{ $description }}</p>
    @endif

    @if(!empty(trim($slot)))
        <div class="mt-4">
            {{ $slot }}
        </div>
    @endif
</div>
