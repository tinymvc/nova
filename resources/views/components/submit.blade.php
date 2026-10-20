@props(['label' => 'Save changes', 'processing' => 'Saving…'])
<button type="submit" :disabled="form.processing" {{ $attributes->class(['btn btn-primary gap-2']) }}>
    <span x-cloak x-show="form.processing" class="loading loading-spinner loading-xs" aria-hidden="true"></span>
    <span x-show="!form.processing">{{ $label }}</span>
    <span x-cloak x-show="form.processing">{{ $processing }}</span>
</button>
