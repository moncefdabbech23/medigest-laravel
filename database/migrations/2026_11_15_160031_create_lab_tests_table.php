<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('lab_tests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('consultation_id')->constrained()->cascadeOnDelete();
            $table->foreignId('patient_id')->constrained()->cascadeOnDelete();
            $table->string('type', 150);                 // ex. Glycémie à jeun
            $table->text('result')->nullable();          // résultat saisi
            $table->string('result_file')->nullable();   // PDF (partie 3 : upload)
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('lab_tests');
    }
};