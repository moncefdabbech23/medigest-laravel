@php($d = $doctor ?? null)

<x-form.errors />

<div class="grid gap-5 md:grid-cols-2">
    <x-form.input name="name" label="Nom complet (ex. Dr Amine Ben Salah)" :value="$d?->user->name" />
    <x-form.input name="email" label="Email" type="email" :value="$d?->user->email" />

    @unless ($d)
        <x-form.input name="password" label="Mot de passe (6 caractères min.)" type="password" />
    @endunless

    <x-form.select name="specialty_id" label="Spécialité" :options="$specialties" :selected="$d?->specialty_id" />
    <x-form.select name="city_id" label="Ville" :options="$cities" :selected="$d?->city_id" />
    <x-form.input name="office_address" label="Adresse du cabinet" :value="$d?->office_address" />
    <x-form.input name="fee" label="Tarif de la consultation (DT)" type="number" step="0.01" min="0" :value="$d?->fee" />
</div>

<x-form.textarea name="description" label="Présentation" :value="$d?->description" rows="4" />

<label class="flex items-center gap-2">
    <input type="hidden" name="is_validated" value="0">
    <input type="checkbox" name="is_validated" value="1" @checked(old('is_validated', $d?->is_validated))>
    Médecin validé (visible dans l’annuaire)
</label>