<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
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
    public function userNotifications(): HasMany
    {
        return $this->hasMany(UserNotification::class);
    }
}