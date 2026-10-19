@if(session()->has('status'))
    <div class="mb-4">
        <x-alert type="success" :message="session('status')" dismissible="true" />
    </div>
@endif

@if(session()->has('success'))
    <div class="mb-4">
        <x-alert type="success" :message="session('success')" dismissible="true" />
    </div>
@endif

@if(session()->has('error'))
    <div class="mb-4">
        <x-alert type="error" :message="session('error')" dismissible="true" />
    </div>
@endif

@if(session()->has('warning'))
    <div class="mb-4">
        <x-alert type="warning" :message="session('warning')" dismissible="true" />
    </div>
@endif

@if(session()->has('info'))
    <div class="mb-4">
        <x-alert type="info" :message="session('info')" dismissible="true" />
    </div>
@endif
