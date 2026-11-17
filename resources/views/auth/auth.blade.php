@extends('layouts.app')
@section('title', $mode === 'register' ? 'Créer un compte' : 'Connexion')

@section('content')
    {{-- Si l'inscription a échoué, on rouvre le formulaire d'inscription --}}
    @php
        if ($errors->register->any()) { $mode = 'register'; }
        if ($errors->login->any()) { $mode = 'login'; }
    @endphp

    <div data-auth data-login-url="{{ route('login') }}" data-register-url="{{ route('register') }}"
         class="auth-box glass-strong mx-auto max-w-5xl rounded-[2rem] {{ $mode === 'register' ? 'is-register' : '' }}">

        {{-- ================= Connexion ================= --}}
        <section class="auth-form auth-login">
            <div class="mx-auto w-full max-w-sm">
                <span class="mb-4 flex size-12 items-center justify-center rounded-2xl bg-gradient-to-br from-teal-400 to-teal-600 text-2xl text-white shadow-lg">🔐</span>
                <h1 class="text-3xl font-bold">Connexion</h1>
                <p class="mt-1 text-sm text-slate-500">Accédez à votre espace MediGest.</p>

                <form method="POST" action="{{ route('login') }}" class="mt-6 space-y-4">
                    @csrf
                    <div>
                        <label for="login_email">Adresse email</label>
                        <input type="email" id="login_email" name="email" value="{{ old('email') }}" placeholder="vous@exemple.tn" autocomplete="email">
                        @if ($errors->login->has('email'))
                            <div class="mt-1 text-xs font-medium text-rose-600">{{ $errors->login->first('email') }}</div>
                        @endif
                    </div>
                    <div>
                        <label for="login_password">Mot de passe</label>
                        <input type="password" id="login_password" name="password" autocomplete="current-password">
                        @if ($errors->login->has('password'))
                            <div class="mt-1 text-xs font-medium text-rose-600">{{ $errors->login->first('password') }}</div>
                        @endif
                    </div>
                    <label class="!mb-0 flex items-center gap-2 font-normal">
                        <input type="checkbox" name="remember" value="1"> Se souvenir de moi
                    </label>
                    <button type="submit" class="btn-primary w-full">Se connecter</button>
                </form>

                {{-- Comptes de démo : seulement en développement (APP_ENV=local) --}}
                @env('local')
                    <p class="mt-6 text-center text-[11px] font-bold uppercase tracking-widest text-slate-400">Comptes de démonstration</p>
                    <div class="mt-2 grid grid-cols-3 gap-2">
                        @foreach ([['Admin', 'admin@medigest.tn', 'admin123'], ['Médecin', 'amine@medigest.tn', 'medecin123'], ['Patient', 'sarra@medigest.tn', 'patient123']] as [$label, $email, $password])
                            <button type="button" data-fill-email="{{ $email }}" data-fill-password="{{ $password }}" class="btn-outline !px-2 text-xs">{{ $label }}</button>
                        @endforeach
                    </div>
                @endenv

                <p class="mt-6 text-center text-sm text-slate-500 lg:hidden">
                    Pas encore de compte ? <button type="button" data-auth-switch="register" class="font-semibold text-teal-700">Créer un compte</button>
                </p>
            </div>
        </section>

        {{-- ================= Inscription ================= --}}
        <section class="auth-form auth-register">
            <div class="mx-auto w-full max-w-sm">
                <span class="mb-4 flex size-12 items-center justify-center rounded-2xl bg-gradient-to-br from-violet-400 to-teal-500 text-2xl text-white shadow-lg">✨</span>
                <h1 class="text-3xl font-bold">Créer un compte</h1>
                <p class="mt-1 text-sm text-slate-500">Compte patient : prenez rendez-vous en ligne.</p>

                <form method="POST" action="{{ route('register') }}" class="mt-5 space-y-3">
                    @csrf
                    @foreach ([['name', 'Nom complet', 'text', 'name'], ['email', 'Adresse email', 'email', 'email'], ['phone', 'Téléphone', 'tel', 'tel']] as [$field, $label, $type, $auto])
                        <div>
                            <label for="register_{{ $field }}">{{ $label }}</label>
                            <input type="{{ $type }}" id="register_{{ $field }}" name="{{ $field }}" autocomplete="{{ $auto }}"
                                   value="{{ $errors->register->any() ? old($field) : '' }}">
                            @if ($errors->register->has($field))
                                <div class="mt-1 text-xs font-medium text-rose-600">{{ $errors->register->first($field) }}</div>
                            @endif
                        </div>
                    @endforeach
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label for="register_password">Mot de passe</label>
                            <input type="password" id="register_password" name="password" autocomplete="new-password">
                        </div>
                        <div>
                            <label for="register_password_confirmation">Confirmation</label>
                            <input type="password" id="register_password_confirmation" name="password_confirmation" autocomplete="new-password">
                        </div>
                    </div>
                    @if ($errors->register->has('password'))
                        <div class="text-xs font-medium text-rose-600">{{ $errors->register->first('password') }}</div>
                    @endif
                    <button type="submit" class="btn-primary w-full">Créer mon compte</button>
                </form>

                <p class="mt-5 text-center text-sm text-slate-500 lg:hidden">
                    Déjà inscrit ? <button type="button" data-auth-switch="login" class="font-semibold text-teal-700">Se connecter</button>
                </p>
            </div>
        </section>

        {{-- ================= Panneau coloré qui glisse (ordinateur) ================= --}}
        <div class="auth-overlay-wrap">
            <div class="auth-overlay bg-gradient-to-br from-teal-500 via-teal-600 to-sky-700">
                <div class="float-y-slow absolute left-[12%] top-[14%] size-20 rounded-full bg-white/20"></div>
                <div class="float-y absolute bottom-[14%] right-[16%] size-14 rounded-2xl border border-white/40 bg-white/15" style="--r:18deg"></div>

                <div class="auth-panel auth-panel-left">
                    <span class="text-5xl">🩺</span>
                    <h2 class="mt-5 text-3xl font-bold">Bon retour !</h2>
                    <p class="mt-3 max-w-xs text-sm leading-6 text-teal-50">Vous avez déjà un compte ? Connectez-vous pour retrouver vos rendez-vous et votre dossier.</p>
                    <button type="button" data-auth-switch="login" class="mt-8 rounded-xl border border-white/60 bg-white/15 px-8 py-3 text-sm font-semibold transition hover:bg-white hover:text-teal-700">Se connecter</button>
                </div>
                <div class="auth-panel auth-panel-right">
                    <span class="text-5xl">✨</span>
                    <h2 class="mt-5 text-3xl font-bold">Nouveau ici ?</h2>
                    <p class="mt-3 max-w-xs text-sm leading-6 text-teal-50">Créez votre compte patient en quelques secondes et réservez en ligne.</p>
                    <button type="button" data-auth-switch="register" class="mt-8 rounded-xl border border-white/60 bg-white/15 px-8 py-3 text-sm font-semibold transition hover:bg-white hover:text-teal-700">Créer un compte</button>
                </div>
            </div>
        </div>
    </div>
@endsection