@props(['action', 'label' => 'Supprimer', 'message' => 'Confirmer la suppression ?'])

<form method="POST" action="{{ $action }}" class="inline">
    @csrf
    @method('DELETE')
    <button type="submit" onclick="return confirm('{{ $message }}')" {{ $attributes->merge(['class' => 'btn-danger']) }}>
        {{ $label }}
    </button>
</form>
