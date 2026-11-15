<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;   
use Illuminate\Database\Eloquent\Relations\HasMany; 
class Patient extends Model
{
    protected $fillable = [
        'user_id', 'birth_date', 'gender', 'blood_type', 'phone',
        'allergies', 'chronic_diseases', 'address', 'emergency_contact',
    ];
    protected $casts = [
        'birth_date' => 'date',
    ];
    // Un patient appartient à UN utilisateur (relation 1-1)
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    // Liste des allergies sous forme de tableau : "Pénicilline, Aspirine" -> ['pénicilline', 'aspirine']
    public function allergyList(): array
    {
        return collect(explode(',', (string) $this->allergies))
            ->map(fn ($a) => mb_strtolower(trim($a)))
            ->filter()
            ->values()
            ->all();
    }
    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class);
    }
    public function labTests(): HasMany
    {
        return $this->hasMany(LabTest::class);
    }
    public function radiologies(): HasMany
    {
        return $this->hasMany(Radiology::class);
    }

}