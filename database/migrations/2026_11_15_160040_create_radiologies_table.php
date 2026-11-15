<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('radiologies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('consultation_id')->constrained()->cascadeOnDelete();
            $table->foreignId('patient_id')->constrained()->cascadeOnDelete();
            $table->string('type', 150);                 // ex. Radiographie thoracique
            $table->text('report')->nullable();          // compte rendu
            $table->string('image')->nullable();         // image (partie 3 : upload)
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('radiologies');
    }
};