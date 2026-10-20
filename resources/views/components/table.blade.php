@props([
    'headers' => [],
    'striped' => false,
    'hover' => true,
    'compact' => false,
])

<div class="overflow-x-auto w-full border border-base-300 rounded-xl">
    <table
        {{ $attributes->class(['table w-full', 'table-zebra' => (bool) $striped, 'table-sm' => (bool) $compact]) }}>
        @if (!empty($headers))
            <thead>
                <tr>
                    @foreach ($headers as $header)
                        <th scope="col">{{ $header }}</th>
                    @endforeach
                </tr>
            </thead>
        @endif

        <tbody class="{{ $hover ? '[&_tr:hover]:bg-base-200/40' : '' }} divide-y divide-base-200">
            {{ $slot }}
        </tbody>
    </table>
</div>
