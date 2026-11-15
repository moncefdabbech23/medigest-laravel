<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;


class Doctor extends Model
{
    protected $fillable = [
        'user_id', 'specialty_id', 'city_id', 'office_address',
        'fee', 'description', 'is_validated',
    ];

    protected $casts = [
        'is_validated' => 'boolean',
        'fee' => 'decimal:2',
    ];

    // Un médecin appartient à UN utilisateur (nom, email)
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Un médecin a UNE spécialité
    public function specialty(): BelongsTo
    {
        return $this->belongsTo(Specialty::class);
    }

    // Un médecin exerce dans UNE ville
    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    // Un médecin a PLUSIEURS disponibilités (une par jour)
    public function availabilities(): HasMany
    {
        return $this->hasMany(Availability::class)->orderBy('weekday');
    }
    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class);
    }
}