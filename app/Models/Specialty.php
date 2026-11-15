<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Specialty extends Model
{
    protected $fillable = ['name', 'icon'];

    // Une spécialité a PLUSIEURS médecins
    public function doctors(): HasMany
    {
        return $this->hasMany(Doctor::class);
    }
}