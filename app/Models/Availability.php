<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Availability extends Model
{
    public const DAYS = [1 => 'Lundi', 2 => 'Mardi', 3 => 'Mercredi', 4 => 'Jeudi', 5 => 'Vendredi', 6 => 'Samedi', 7 => 'Dimanche'];

    protected $fillable = ['doctor_id', 'weekday', 'start_time', 'end_time', 'slot_duration', 'is_active'];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function doctor(): BelongsTo
    {
        return $this->belongsTo(Doctor::class);
    }

    // Nom du jour en français : $availability->dayName()
    public function dayName(): string
    {
        return self::DAYS[$this->weekday] ?? '';
    }
}