@if (session('success'))
    <x-alert data-autohide class="mb-6">{{ session('success') }}</x-alert>
@endif