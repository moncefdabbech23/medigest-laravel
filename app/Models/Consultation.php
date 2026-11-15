<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
class Consultation extends Model
{
    protected $fillable = ['appointment_id', 'diagnosis', 'notes'];
    public function appointment(): BelongsTo
    {
        return $this->belongsTo(Appointment::class);
    }
    public function prescription(): HasOne
    {
        return $this->hasOne(Prescription::class);
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
