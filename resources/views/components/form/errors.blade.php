@if ($errors->any())
    <x-alert type="danger" {{ $attributes }}>
        <p>Le formulaire contient des erreurs :</p>
        <ul class="mt-1 list-disc pl-5 font-normal">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </x-alert>
@endif
