@props([
    'headers' => [],
    'striped' => false,
    'hover' => true,
    'compact' => false,
])

<div class="overflow-x-auto w-full border border-base-200 rounded-lg">
    <table {{ $attributes->class([
        'table w-full',
        'table-zebra' => (bool) $striped,
        'table-sm' => (bool) $compact,
    ]) }}>
        @if(!empty($headers))
            <thead class="bg-base-200/50 text-base-content/80 text-xs uppercase font-semibold">
                <tr>
                    @foreach($headers as $header)
                        <th>{{ $header }}</th>
                    @endforeach
                </tr>
            </thead>
        @endif

        <tbody class="{{ $hover ? '[&_tr:hover]:bg-base-200/40' : '' }} divide-y divide-base-200">
            {{ $slot }}
        </tbody>
    </table>
</div>
