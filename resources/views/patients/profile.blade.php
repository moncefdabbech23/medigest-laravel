{{-- resources/views/patients/profile.blade.php --}}
@extends('layouts.admin')
@section('title', 'Mon profil')
@section('content')
    <h1 class="mb-6 text-2xl font-bold">Mon profil</h1>
    <x-form.errors class="mb-4" />
    <div class="grid gap-6 lg:grid-cols-[1fr_320px]">
        {{-- Informations personnelles et médicales --}}
        <form method="POST" action="{{ route('my.profile.update') }}" enctype="multipart/form-data"
            class="glass space-y-5 rounded-2xl p-6">
            @csrf
            @method('PUT')
            <div class="flex items-center gap-4">
                @if ($user->avatar)
                    <img src="{{ asset('storage/' . $user->avatar) }}" alt="Photo de profil" class="size-20
                        rounded-2xl object-cover shadow-lg">
                @else
                    <span class="flex size-20 items-center justify-center rounded-2xl bg-gradient-to-br
                        from-teal-400 to-sky-500 text-3xl font-bold text-white shadow-lg">
                        {{ mb_substr($user->name, 0, 1) }}
                    </span>
                @endif
                <div class="flex-1">
                    <label for="avatar">Photo de profil (2 Mo max.)</label>
                    <input type="file" id="avatar" name="avatar" accept="image/*">
                </div>
            </div>
            <div class="grid gap-4 md:grid-cols-2">
                <x-form.input name="name" label="Nom complet" :value="$user->name" />
                <x-form.input name="phone" label="Téléphone" :value="$patient->phone" />
                <x-form.input name="birth_date" label="Date de naissance" type="date"
                    :value="$patient->birth_date?->format('Y-m-d')" />
                <div>
                    <label for="gender">Sexe</label>
                    <select id="gender" name="gender">
                        <option value="">—</option>
                        <option value="F" @selected(old('gender', $patient->gender) === 'F')>Femme</option>
                        <option value="M" @selected(old('gender', $patient->gender) === 'M')>Homme</option>
                    </select>
                </div>
                <div>

                    <label for="blood_type">Groupe sanguin</label>
                    <select id="blood_type" name="blood_type">
                        <option value="">—</option>
                        @foreach (['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'] as $group)
                            <option value="{{ $group }}" @selected(old('blood_type', $patient->blood_type) ===
                                $group)>{{ $group }}</option>
                        @endforeach
                    </select>
                </div>
                <x-form.input name="address" label="Adresse" :value="$patient->address" />
            </div>
            <x-form.input name="allergies" label="Allergies (séparées par des virgules)"
                :value="$patient->allergies" />
            <x-form.input name="chronic_diseases" label="Maladies chroniques"
                :value="$patient->chronic_diseases" />
            <x-form.input name="emergency_contact" label="Contact d’urgence"
                :value="$patient->emergency_contact" />
            <button type="submit" class="btn-primary">Enregistrer mon profil</button>
        </form>
        {{-- Mot de passe --}}
        <form method="POST" action="{{ route('my.password.update') }}" class="glass h-fit space-y-4 rounded-2xl
            p-6">
            @csrf
            @method('PUT')
            <h2 class="font-bold">Changer le mot de passe</h2>
            <x-form.input name="current_password" label="Mot de passe actuel" type="password" />
            <x-form.input name="password" label="Nouveau mot de passe" type="password" />
            <x-form.input name="password_confirmation" label="Confirmer le nouveau" type="password" />
            <button type="submit" class="btn-outline w-full">Modifier</button>
        </form>
    </div>
@endsection