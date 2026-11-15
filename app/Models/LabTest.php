<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
class Prescription extends Model
{
    protected $fillable = ['consultation_id', 'date'];
    protected $casts = [
        'date' => 'date',
    ];
    public function consultation(): BelongsTo
    {
        return $this->belongsTo(Consultation::class);
    }
    // Relation N-N avec les colonnes de la table pivot
    public function medications(): BelongsToMany
    {
        return $this->belongsToMany(Medication::class)
            ->withPivot('dosage', 'frequency', 'duration');
    }
}