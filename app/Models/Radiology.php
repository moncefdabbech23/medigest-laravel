<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class Radiology extends Model
{
    protected $fillable = ['consultation_id', 'patient_id', 'type', 'report', 'image'];
    public function consultation(): BelongsTo
    {
        return $this->belongsTo(Consultation::class);
    }
    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }
}