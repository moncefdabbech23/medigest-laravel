<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
class ProfileController extends Controller
{
    // /my/profile
    public function edit(Request $request)
    {
        $user = $request->user();
        $patient = $user->patient;
        return view('patients.profile', compact('user', 'patient'));
    }
    // PUT /my/profile
    public function update(Request $request)
    {
        $user = $request->user();
        $patient = $user->patient;
        $data = $request->validate([
            'name' => 'required|max:150',
            'phone' => 'nullable|max:20',
            'birth_date' => 'nullable|date|before:today',
            'gender' => 'nullable|in:M,F',
            'blood_type' => 'nullable|in:A+,A-,B+,B-,AB+,AB-,O+,O-',
            'allergies' => 'nullable|max:500',
            'chronic_diseases' => 'nullable|max:500',
            'address' => 'nullable|max:255',
            'emergency_contact' => 'nullable|max:255',
            'avatar' => 'nullable|image|max:2048',
        ]);
        $userData = ['name' => $data['name']];
        if ($request->hasFile('avatar')) {
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }
            $userData['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }
        DB::transaction(function () use ($user, $patient, $userData, $data) {
            $user->update($userData);
            $patient->update(collect($data)->only([
                'phone', 'birth_date', 'gender', 'blood_type', 'allergies',
                'chronic_diseases', 'address', 'emergency_contact',
            ])->all());
        });
        return to_route('my.profile.edit')->with('success', 'Profil mis à jour.');
    }
    // PUT /my/password
    public function updatePassword(Request $request)
    {
        $data = $request->validate([
            'current_password' => 'required|current_password',   // vérifie l'ancien mot de passe
            'password' => 'required|min:6|confirmed',            // doit être égal à password_confirmation
        ]);
        $request->user()->update(['password' => $data['password']]);   // chiffré par le cast 'hashed'
        return to_route('my.profile.edit')->with('success', 'Mot de passe modifié.');
    }
}