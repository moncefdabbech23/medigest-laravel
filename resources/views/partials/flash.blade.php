@if (session('success'))
    <x-alert data-autohide class="mb-6">{{ session('success') }}</x-alert>
@endif

@if (session('error'))
    <x-alert type="danger" class="mb-6">{{ session('error') }}</x-alert>
@endif