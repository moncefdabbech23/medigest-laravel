@if (session('success'))
    <div data-autohide class="glass mb-6 rounded-xl border-l-4 border-l-teal-500 px-4 py-3 text-sm font-semibold text-teal-800">
        {{ session('success') }}
    </div>
@endif
