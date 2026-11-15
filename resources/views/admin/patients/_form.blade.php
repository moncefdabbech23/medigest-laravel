{{-- resources/views/admin/patients/_form.blade.php (partagé par create et edit) --}}
@php($p = $patient ?? null)
<div class="grid gap-4 md:grid-cols-2">
    <x-form.input name="name" label="Nom complet" :value="$p?->user->name" />
    <x-form.input name="email" label="Email" type="email" :value="$p?->user->email" />
    @unless ($p)
        <x-form.input name="password" label="Mot de passe" type="password" />
    @endunless
    <x-form.input name="birth_date" label="Date de naissance" type="date"
        :value="$p?->birth_date?->format('Y-m-d')" />
    <div>
        <label for="gender">Sexe</label>
        <select name="gender" id="gender">
            <option value="">—</option>
            <option value="F" @selected(old('gender', $p?->gender) === 'F')>Femme</option>
            <option value="M" @selected(old('gender', $p?->gender) === 'M')>Homme</option>
        </select>
    </div>
    <div>
        <label for="blood_type">Groupe sanguin</label>
        <select name="blood_type" id="blood_type">
            <option value="">—</option>
            @foreach (['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'] as $g)
                <option value="{{ $g }}" @selected(old('blood_type', $p?->blood_type) === $g)>{{ $g }}</option>
            @endforeach
        </select>
        @error('blood_type') <div class="text-red-600">{{ $message }}</div> @enderror
    </div>
    <x-form.input name="phone" label="Téléphone" :value="$p?->phone" />
    <x-form.input name="allergies" label="Allergies (séparées par des virgules)" :value="$p?->allergies" />
    <x-form.input name="chronic_diseases" label="Maladies chroniques" :value="$p?->chronic_diseases" />
    <x-form.input name="address" label="Adresse" :value="$p?->address" />
    <x-form.input name="emergency_contact" label="Contact d’urgence" :value="$p?->emergency_contact" />
</div>
