<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LabTest extends Model
{
    protected $fillable = ['consultation_id', 'patient_id', 'type', 'result'];

    // Une analyse appartient à une consultation
    public function consultation(): BelongsTo
    {
        return $this->belongsTo(Consultation::class);
    }

    // ... et à un patient
    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }
}