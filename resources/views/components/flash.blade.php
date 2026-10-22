@foreach (['status' => 'success', 'success' => 'success', 'error' => 'error', 'warning' => 'warning', 'info' => 'info'] as $key => $type)
    @php($message = session()->getFlash($key))
    @if ($message)
        <div class="mb-6" key="flash-{{ $key }}-{{ md5((string) $message) }}-{{ microtime(true) }}">
            <x-alert :$type :$message :dismissible="true" />
        </div>
    @endif
@endforeach
