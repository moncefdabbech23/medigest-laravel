<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
// Table pivot N-N : les deux modèles au singulier, par ordre alphabétique
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('medication_prescription', function (Blueprint $table) {
            $table->id();
            $table->foreignId('medication_id')->constrained()->restrictOnDelete();
            $table->foreignId('prescription_id')->constrained()->cascadeOnDelete();
            $table->string('dosage', 100);      // ex. 1 comprimé
            $table->string('frequency', 100);   // ex. 3 fois par jour
            $table->string('duration', 100);    // ex. 5 jours
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('medication_prescription');
    }
};
