@props(['action', 'method' => 'POST'])
<form action="{{ $action }}" method="{{ strtoupper($method) === 'GET' ? 'GET' : 'POST' }}" x-data="{ form: $form() }"
    x-form {{ $attributes->class(['flex flex-col gap-5']) }}>
    @if (strtoupper($method) !== 'GET')
        @csrf
    @endif
    @if (!in_array(strtoupper($method), ['GET', 'POST']))
        @method($method)
    @endif
    {{ $slot }}
    <div x-cloak x-show="form.message"
        :class="form.status === 'success' ? 'text-success-content bg-success' : 'text-error-content bg-error'"
        class="rounded-lg px-4 py-3 text-sm" role="status" aria-live="polite"
        x-text="form.status === 'validation' ? 'Please check the highlighted fields.' : form.message"></div>
</form>
