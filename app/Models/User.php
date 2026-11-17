<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password', 'role'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Un utilisateur patient a UNE fiche patient (relation 1-1)
    public function patient(): HasOne
    {
        return $this->hasOne(Patient::class);
    }

    // Un utilisateur médecin a UNE fiche médecin (relation 1-1)
    public function doctor(): HasOne
    {
        return $this->hasOne(Doctor::class);
    }

    // Un utilisateur a PLUSIEURS notifications (relation 1-N)
    public function userNotifications(): HasMany
    {
        return $this->hasMany(UserNotification::class);
    }
    // Libellé du rôle en français : $user->roleLabel()
public function roleLabel(): string
{
    return ['admin' => 'Administrateur', 'doctor' => 'Médecin', 'patient' => 'Patient'][$this->role] ?? $this->role;
}

// Page d'accueil de l'utilisateur selon son rôle : $user->homeUrl()
public function homeUrl(): string
{
    $candidates = match ($this->role) {
        'admin' => ['admin.dashboard'],
        'doctor' => ['doctor.appointment.index'],
        default => ['my.appointment.index', 'patient.appointment.index'],
    };

    foreach ($candidates as $name) {
        if (\Illuminate\Support\Facades\Route::has($name)) {
            $needed = \Illuminate\Support\Facades\Route::getRoutes()->getByName($name)->parameterNames();
            $params = array_intersect_key(
                ['doctor' => $this->doctor?->id, 'patient' => $this->patient?->id],
                array_flip($needed)
            );

            return route($name, $params);
        }
    }

    return route('home');
}
}