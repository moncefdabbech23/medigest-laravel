<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

class AuthController extends Controller
{
    // GET /login
    public function showLogin()
    {
        return view('auth.auth', ['mode' => 'login']);
    }

    // GET /register
    public function showRegister()
    {
        return view('auth.auth', ['mode' => 'register']);
    }

    // POST /login
    public function login(Request $request)
    {
        $credentials = $request->validateWithBag('login', [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Auth::attempt vérifie l'email et le mot de passe chiffré dans la table users
        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();   // sécurité : nouvelle session après connexion

            // intended() : revenir à la page demandée avant la connexion (ex. réserver un rendez-vous)
            return redirect()->intended($this->homeFor($request->user()))
                ->with('success', 'Bienvenue ' . $request->user()->name . ' !');
        }

        return back()
            ->withErrors(['email' => 'Email ou mot de passe incorrect.'], 'login')
            ->onlyInput('email');
    }

    // POST /register : seuls les patients s'inscrivent eux-mêmes (les médecins sont ajoutés par l'admin)
    public function register(Request $request)
    {
        $data = $request->validateWithBag('register', [
            'name' => 'required|max:150',
            'email' => 'required|email|max:150|unique:users,email',
            'phone' => 'nullable|max:20',
            'password' => 'required|min:6|confirmed',
        ]);

        // Le compte et la fiche patient sont créés ensemble, ou pas du tout
        $user = DB::transaction(function () use ($data) {
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => $data['password'],   // chiffré par le cast 'hashed'
                'role' => 'patient',
            ]);

            $user->patient()->create(['phone' => $data['phone'] ?? null]);

            return $user;
        });

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->intended($this->homeFor($user))
            ->with('success', 'Compte créé. Bienvenue sur MediGest !');
    }

    // POST /logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();       // vider la session
        $request->session()->regenerateToken();  // nouveau jeton CSRF

        return to_route('home')->with('success', 'Vous êtes déconnecté.');
    }

    // Page d'accueil de chaque rôle après la connexion
    private function homeFor(User $user): string
    {
        return match ($user->role) {
            'admin' => route('admin.dashboard'),

            'doctor' => Route::has('doctor.appointment.index') && $user->doctor
                ? route('doctor.appointment.index', ['doctor' => $user->doctor->id])
                : route('home'),

            default => match (true) {
                Route::has('my.appointment.index') => route('my.appointment.index'),           // après B13
                Route::has('patient.appointment.index') && (bool) $user->patient
                    => route('patient.appointment.index', $user->patient),                    // partie 2
                default => route('home'),
            },
        };
    }
}