<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
class Appointment extends Model
{
    // Les 4 statuts possibles
    public const PENDING = 'pending';
    public const CONFIRMED = 'confirmed';
    public const CANCELLED = 'cancelled';
    public const DONE = 'done';
    // Libellés affichés en français
    public const LABELS = [
        'pending' => 'En attente',
        'confirmed' => 'Confirmé',
        'cancelled' => 'Annulé',
        'done' => 'Terminé',
    ];
    protected $fillable = ['patient_id', 'doctor_id', 'date', 'time', 'reason', 'status'];
    protected $casts = [
        'date' => 'date',
    ];
    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }
    public function doctor(): BelongsTo
    {
        return $this->belongsTo(Doctor::class);
    }
    // Un rendez-vous terminé a UNE consultation (étape B4)
    public function consultation(): HasOne
    {
        return $this->hasOne(Consultation::class);
    }
    public function statusLabel(): string
    {
        return self::LABELS[$this->status] ?? $this->status;
    }
    // Heure au format 09:30 (la base renvoie 09:30:00)
    public function hour(): string
    {
        return substr($this->time, 0, 5);
    }
}